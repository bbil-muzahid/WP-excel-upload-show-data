<?php
    // ENSURE ALL ARRY ELEMENTS ARE UNIQUE AND NOT AN EMPTY ARRAY
    if(isset($_POST['btn_submit'])){
        if ( isset($_FILES['xml_file']) ){
            $xml_file = $_FILES["xml_file"];
            $upload = $backend->xml_insert($xml_file);
            if ($upload) { $backend->throw_success_msg('success!'); }
            else{$backend->throw_error_msg('something went wrong'); }
            //var_dump($upload);
            //$upload = $upload = $backend->xml_upload($xml_file);
            //echo "<pre>"; print_r($upload);echo "<pre>";
        }
        //echo $xml_file; die();

    } else {
        //$data = $backend->delete_table(BBITEMPTABLE);
        //$data = $backend->rowCount();
        //var_dump($data);
        //echo "<pre>"; print_r($data); echo "<pre>";
    }
?>
<!--link rel="stylesheet" href="<?php //echo plugin_dir_url( __FILE__ ); ?>css/main.css" type="text/css"-->
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

<style> 
    body {overflow-x: hidden; padding-right: 15px;} 
    div.section-credit-confusing div.container{max-width:100%; }
    <?php if ( $homeStyleNo == 2 ) { echo ".hidefromadmin{display: none; }"; } ?>
</style>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group"><input type="file" name="xml_file" id="xml_file"></div>
    <div class="form-group">
        <label class="col-sm-3"></label>
        <div class="col-sm-6">
            <!-- <button type="button" class="btn btn-danger" id="reset" name="reset">CLEAR</button> -->
            <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-success">UPLOAD FILE</button>
        </div>
        <div class="col-sm-3"></div>
    </div>
</form>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>