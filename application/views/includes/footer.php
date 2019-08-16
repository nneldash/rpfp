    
	</body>
	<script>
	    document.onkeydown=function(evt){
	        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
	        if(keyCode == 13)
	        {
	            $('#login_form').submit();
	        }
	    }
	</script>
</html>