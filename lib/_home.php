<?php if(settings('home')=='')

{

 ?>
<div class="col-lg-3">
</div>
<div class="col-lg-5">
<div align="center">
<br><br>
                       
<h1 class="logo">Welcome to V<span>o</span>r { }</h1>
<h1><i class="fa fa-code"></i></h1>
Developed by

<h3>Trino Lab <sup> © </sup></h3>

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