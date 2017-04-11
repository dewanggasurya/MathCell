var pagePos = 1;
function getTableScore(page){
	$.post('../request/getTableScore.php',{p:page}, function(data){					
		if(data.count>0 && page!=0){
			$('#data-table').html('');
			$.each(data.response,function(k, v){				
				$('#data-table').append("<tr><td>"+v.position+"</td><td>"+v.name+"</td><td>"+v.level+"</td><td>"+v.score+"</td></tr>");
			});			
			pagePos=page;
		}
	},'json');
}
 
$(function(){
	getTableScore(pagePos);
	
	$('#next').click(function(){
		getTableScore(pagePos+1);
	});
	
	$('#prev').click(function(){
		getTableScore(pagePos-1);
	});
	
});