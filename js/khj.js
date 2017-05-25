var $ =		require('jquery'),
	fs =	require('fs'),			//파일을 읽고 쓸 수 있음.
	express = require('express'),
	app =	express(),	//파일을 라우팅하고 각종 권한을 조율하는 express.js(굉장히 중요)
	http =	require('http').Server(app),
	io =	require('socket.io')(http),
	mysql=	require('mysql'),
	url =	require('url'),
	md5 =	require('js-md5'),
	qs =	require('querystring'),
	phpExpress = require('php-express')({binPath: 'php'}),
	bodyParser = require('body-parser'),
	cookieParser = require('cookie-parser'),
	session = require('php-session-middleware'),
	multipart = require('connect-multiparty');

//////////////////////////////////////////////////////////////////////////////////////////////

//bodyParser를 통한 json과 urlencoded 사용 허용(GET,POST 변수를 주고받을 수 있게 함.
app
	.use(cookieParser('capstone'))
	.use(new session({
		handler:'file',
		opts:{
			path:'/tmp/'
		}
	}));
app.use(multipart({uploadDir:__dirname+"/tmp"}));
app.use(bodyParser.json({limit:'100mb'}));
app.use(bodyParser.urlencoded({extended:true}));
//CORS header 추가
//app.use(function(req, res) { res.header('Access-Control-Allow-Origin', '*') });
var multipartMiddleware = multipart({uploadDir:__dirname+"/tmp"});
//express.js를 통한 서버 설정.
app.set('views', '../');

//PHP 엔진 설정
app.engine('php', phpExpress.engine);
app.set('view engine', 'php');

app.get('/.htaccess', function(req, res)
{
	res.sendFile('/var/www/html/v2/.htaccess');
});

//캡스톤 자바스크립트 설정
app.get('/js/capstone.js', function(req, res)
{
	res.sendFile('/var/www/html/v2/js/capstone.js');
});
app.get('/js/imagePreview.js', function(req, res)
{
	res.sendFile('/var/www/html/v2/js/imagePreview.js');
});

//모든 php 확장자의 파일은 php-express를 통해 라우팅 되도록 설정.
app.all(/.+\.php$/, phpExpress.router);
// routing all .php file to php-express

//////////////////////////////////////////////////////////////////////////////////////////////

var sql=mysql.createPool(
	{
		host				: 'localhost',
		port				: '3306',
		user				: 'root',
		password			: 'zoqtmxhs',
		database			: 'capstone',
		connectionLimit		: 10000,
		insecureAuth		: 'true'
	});
sql.query("set names utf8");

app.post("/upload", multipartMiddleware, function(req,res)
{
	res.redirect(307,"/upload_check.php");
});

function UserInfo(uID, uName, uToken, uClient)
{
	this.id = uID;
	this.name = uName;
	this.uToken = uToken;
	this.socket = uClient;
}

// 토큰이 유효한지 검사한다.
function isValidToken(id,name,token)
{
	var ret = md5("caps"+id+"tone"+name);
	return token == ret;
}



//클라이언트가 최초로 접속을 할 시
io.on('connection', function(client)
{
	client.on('error',function(error)
	{
	});

	//서버가 먼저 인증을 요청한다.
	client.emit("auth");

	//send information이라는 명령어로 서버에게 인증을 보냈을 때(id, 닉네임, 토큰, 공방 번호)
	client.on('send information',function(id,name,token,room)
	{
		sql.query("SELECT * FROM dg_file_list WHERE workshop_no="+room,function(err, rows, fields){
			client.emit("send file_list", rows);
		});
		
		//token의 유효성을 검사한다.
		if(isValidToken(id,name,token))
		{

			//그룹을 나눈다.
			client.join(room);


			//요청된 공방 정보를 가져온다.
			sql.query("select name,description from dg_workshop where no = "+room,function(err,rows,fields)
			{
				if(err) console.log(err);

				if(rows.length>0)
				{
					client.emit("send subject", rows[0].name, rows[0].description);
				}
				else
				{
					client.emit("subject error");
				}
			});

			//공방에 적용되어 있는 단계를 가져온다.
			sql.query("select * from dg_workshop_process where workshop_no = "+room+" order by process_no asc",function(err,rows,fields)
			{
				if(err) console.log(err);

				if(rows.length > 0)
				{
					client.emit("send process name", rows);
				}
			});




			client.emit("greeting");
		}
		else console.log("invalid token");
	});

	//공방에 있는 글을 가져온다.
	client.on("send workshop contents", function(id, name, token, room)
	{
		if(isValidToken(id,name,token))
		{
			/////////////////////////////////////////////////////////////////rating///////////////////////////////////////////////////
			sql.query("SELECT dg_member.nickname, dg_write.member_no, AVG(dg_star.star_score) AS score , dg_write.process_no, dg_file_list.file_no, dg_file_list.upload_date, dg_file_list.title, dg_file_list.description, dg_file_list.file_ver" +
				" FROM dg_write, dg_member,(SELECT * FROM (SELECT * FROM dg_file_list ORDER BY file_no DESC)A WHERE workshop_no = "+sql.escape(room)+" GROUP BY parent_no ORDER BY parent_no DESC) dg_file_list LEFT OUTER JOIN dg_star ON dg_star.file_no = dg_file_list.file_no WHERE dg_write.write_no = dg_file_list.parent_no AND dg_member.mem_no = dg_write.member_no" +
				" GROUP BY dg_member.nickname, dg_write.member_no,dg_write. process_no,dg_file_list.file_no, dg_file_list.upload_date,dg_file_list.title, dg_file_list.description, dg_file_list.file_ver" +
				" ORDER BY dg_write.process_no ASC, dg_file_list.upload_date DESC",function(err,rows,fields)
			{
				/////////////////////////////////////////////////////////////////rating///////////////////////////////////////////////////
				if(typeof(rows) != "undefined" && rows.length > 0)
				{

					client.emit("send workshop contents", rows);
				}
			});
		}
	});

	//각 단계의 이름을 변경한다.
	client.on("update subject", function(id, name, token, room, parentID, workshopID, processID, value)
	{
		if(isValidToken(id,name,token))
		{
			sql.query("select dg_member.nickname, dg_workshop_member.workshop_no, dg_workshop_member.member_no, dg_member.mem_no from dg_workshop_member, (select * from dg_member where nickname = "+sql.escape(name)+")dg_member where workshop_no = "+room+" and dg_workshop_member.member_no = dg_member.mem_no",function(err,rows,fields)
			{
				if(!err && typeof(rows)!="undefined" && rows.length > 0)
				{
					sql.query("update dg_workshop_process set name="+sql.escape(value)+" where workshop_no = "+workshopID+" and process_no = "+processID,function(err,rows,fields)
					{
						if(err) console.log(err);

						else
						{
							io.sockets.in(room).emit("update subject", parentID, value);
						}
					});
				}
			});
		}
	});

	//새로 올라온 글을 추가한다.
	client.on("refresh content", function(id, name, token, room, no)
	{
		if(isValidToken(id,name,token))
		{
			sql.query("SELECT dg_member.nickname, dg_write.member_no, dg_write.process_no, dg_file_list.file_no, dg_file_list.upload_date, dg_file_list.title, dg_file_list.description, dg_file_list.file_ver from dg_write, dg_member,(SELECT * FROM (select * from dg_file_list ORDER by file_no desc)A where file_no = "+no+" group by parent_no order by parent_no desc)dg_file_list where dg_write.write_no = dg_file_list.parent_no and dg_member.mem_no = dg_write.member_no order by dg_write.process_no asc, dg_file_list.upload_date desc",function(err,rows,fields)
			{

				if(!err && typeof(rows)!="undefined" && rows.length > 0)
				{
					io.sockets.in(room).emit("send workshop contents", rows);
				}
				else
					console.log(err);
			});
		}
		else
			console.log("YY");
	});
	//새로운 단계를 추가한다.
	client.on("add new process", function(id, name, token, room)
	{
		if(isValidToken(id,name,token))
		{
			//먼저 유저가 존재하는지 확인한다.
			sql.query("select dg_member.nickname, dg_workshop_member.workshop_no, dg_workshop_member.member_no, dg_member.mem_no from dg_workshop_member, (select * from dg_member where nickname= "+sql.escape(name)+")dg_member where workshop_no = "+room+" and dg_workshop_member.member_no = dg_member.mem_no",function(err,rows,fields)
			{
				if (err)
				{
					console.log(err);
				}
				else if(typeof(rows) != "undefined" && rows.length > 0)
				{
					//dg_workshop_process에 새로운 단계란 이름으로 insert를 해주며, 번호는 max +1 로 해준다.
					sql.query("insert into dg_workshop_process(workshop_no, process_no, name) values("+room+",(select count(process_no) from (select * from dg_workshop_process)dg_workshop_process where workshop_no="+room+")+1, '새로운 단계');", function(err, rows, fields)
					{
						if(!err)
						{
							io.sockets.in(room).emit("update card");
						}
					});
				}
				else
				{
					//권한이 없음을 유저에게 알려준다.
					client.emit("Permission denied");
				}
			});
		}
		else console.log("wrong token");
	});
	/////////////////////////////////////////////////////rating//////////////////////////////////////////////////////////////////////////////
	client.on("update score", function(id, name, token, star_num, file_no)
	{
		if(isValidToken(id,name,token))
		{
			//먼저 유저가 존재하는지 확인한다.
			sql.query("SELECT nickname FROM dg_star WHERE file_no = "+file_no+" AND nickname ="+sql.escape(name),function(err,rows,fields)
			{
				console.log(rows);
				//유저가 있으면 수정
				if(rows.length > 0)
				{
					sql.query("UPDATE dg_star SET star_score="+star_num+" WHERE file_no="+file_no+" and nickname = "+sql.escape(name), function(err, rows, fields)
					{
						console.log(file_no);
						console.log("RATING UPDATE OK");
						client.emit("send score", rows);
					});
				}
				//유저가 없으면 삽입
				else{
					//dg_workshop_process에 새로운 단계란 이름으로 insert를 해주며, 번호는 max +1 로 해준다.
					sql.query("INSERT INTO dg_star (nickname, file_no, star_score) VALUES ('"+name+"',"+file_no+","+star_num+");", function(err, rows, fields)
					{
						console.log("RATING INSERT OK");
						client.emit("send score", rows);
					});
				}
			});

		}
	});
	////////////////////////////////////////////////////////////////////////////////////////////////////////
});




http.listen(10001, function()
{
	console.log('now open *:10001.');
});