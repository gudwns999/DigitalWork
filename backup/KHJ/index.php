<script>
var answer = 0;

function generate(w,h)
{
	var arr = Array();
	for(var i=0;i<w;i++)
	{
		arr[i] = Array();
		for(var j=0;j<h;j++)
		{
			arr[i][j] = Math.ceil(Math.random()*10)+1;
		}
	}
	return arr;
}

function solution(A,B)
{
	var w=A.length, h= A[0].length;
	var arr = Array();
	for(var i=0;i<w;i++)
	{
		arr[i] = Array();
		for(var j=0;j<h;j++)
			arr[i][j] = A[i][j]+B[i][j];
	}
	return arr;
}
var w = Math.ceil(Math.random()*5)+1;
var h = Math.ceil(Math.random()*5)+1;
var A = generate(w,h);
var B = generate(w,h);
var answer = solution(A,B);

for(var i=0;i<w;i++)
{
	for(var j=0;j<h;j++)
		console.log(answer[i][j]+"("+A[i][j]+"+"+B[i][j]+") ");
	console.log("\n");
}
describe("",function(){
	Test.assertEquals(sumMatrix(A,B),answer, "sumMatrix()의 결과가 틀립니다.")
});
	</script>