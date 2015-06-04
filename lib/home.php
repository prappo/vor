<?php if(settings('home')=='')

{

 ?>
<div class="col-lg-3">
</div>
<div class="col-lg-5">
<div align="center">
<br><br>
 <img src="img/logo.png"><br>                      
<h1 class="logo black">Welcome to V<span>o</span>r { }</h1>
<h1 class="black"><i class="fa fa-code black"></i></h1>
<h4 class="black">Developed by</h4>

<h3 class="black">Trino Lab <sup> © </sup></h3>

</div>
</div>
<div class="col-lg-3">
</div>
<?php 

}
else
{

	echo settings('home');
}


 ?>