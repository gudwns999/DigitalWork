var $ =		require('jquery'),
	fs =	require('fs'),			//파일을 읽고 쓸 수 있음.
	app =	require('express')(),	//파일을 라우팅하고 각종 권한을 조율하는 express.js(굉장히 중요)
	http =	require('http').Server(app),
	io =	require('socket.io')(http),
	mysql=	require('mysql'),
	md5 =	require('js-md5'),
	phpExpress = require('php-express')({binPath: 'php'}),
	bodyParser = require('body-parser');

//////////////////////////////////////////////////////////////////////////////////////////////

//express.js를 통한 서버 설정.
app.set('views', '../../');

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

//bodyParser를 통한 json과 urlencoded 사용 허용(GET,POST 변수를 주고받을 수 있게 함.
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended:true}));


//모든 php 확장자의 파일은 php-express를 통해 라우팅 되도록 설정.
app.all(/.+\.php$/, phpExpress.router);
// routing all .php file to php-express

//////////////////////////////////////////////////////////////////////////////////////////////

var MEMBER_LIST = [];

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

function UserInfo(uID, uName, uToken, uClient)
{
	this.id = uID;
	this.name = uName;
	this.uToken = uToken;
	this.socket = uClient;
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
		//token의 유효성을 검사한다.
		var test = md5("caps"+id+"tone"+name);
		if(token != test)
			client.emit("invalid token");
		else
		{
			//손님인 경우에는 MEMBER_LIST에 넣을 필요가 없으며, 회원인 경우도 중복해서 넣지는 않는다.
			if(id != "guest" && MEMBER_LIST[id] !== "undefined")
			{
				var userInfo = new UserInfo(id,name,token,client);
			
				MEMBER_LIST[id] = userInfo;
			}
			//요청된 공방 정보를 가져온다.
			sql.query("select name,description from dg_workshop where no = "+room,function(err,rows,fields)
			{
				if(rows.length>0)
					client.emit("subject", rows[0].name, rows[0].description);
				else
					client.emit("subject error");
			});


			client.emit("greeting");
		}
	});

	client.on('member list',function()
	{
		for (i in MEMBER_LIST)
		{
			client.emit("receive member list",MEMBER_LIST[i].socket);
		}
	});
});



http.listen(9000, function()
{
	console.log('now open *:9000.');
});