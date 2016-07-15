var nummove=0;
var numout=0;
$(function(){
 $(".imglist li").hover(
	function(){
		if(nummove==0)
		{
			nummove=1;
			$("a",this).animate({ width: "0px",left: "91.5px"},80,function(){nummove=0;});
			$("a",this).animate({ width: "183px",left: "0px"},80);
			var bsrc = $("a",this).css("background-image");
			var bjj = $("a",this).attr("bsrc");
			//var imgurl = "url("+bjj+")";
			$("a",this).attr("bsrc",bsrc);
			$("a",this).css("background-image",bjj);
			//$("a",this).css("background","yellow");
			//$("img",this).src=$("img",this).eq(1).src);
			nummove=0;
		}
	},
	function(){
		if(numout==0)
		{
			numout=1;
			$("a",this).animate({ width: "0px",left: "91.5px"},80,function(){numout=0;});
			$("a",this).animate({ width: "183px",left: "0px"},80);
			var bjj = $("a",this).css("background-image");
			var bsrc = $("a",this).attr("bsrc");
			//var imgurl = "url("+bsrc+")";
			$("a",this).attr("bsrc",bjj);
			$("a",this).css("background-image",bsrc);
			//$("img",this).src=$("img",this).eq(1).src);
			numout=0;
		}
	}
 )
});