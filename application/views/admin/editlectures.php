

<div class="child">

      

                

<div class="card-stacked" style="width: 32rem;">
    <div class="card-content" ><br>
        <form action="<?= base_url() ?>" method="post">
      
  
         <div class="card-body">
       <h5 class="card-title">Instructional Lectures</h5>
       </div>
            <div class=form-group>
           <div class="container-sm">
           <h6 class="card-title">Video Name</h6>
            <div class ="input-group">
            <input type ="text" id="inputfield" style="width: 32rem;"required class="input-area">
            <label for ="inputfield" class="label">Enter Video Name</label>
            </div>
          
            <h6 class="card-title">Owner</h6>
            <div class ="input-group">
            <div class="input-field col s5">
                    <select id="" name="" class="form-control col s4">
                        <option value="Sample">Bulk Actions</option>
                        <option value="Sample">Sample</option>
                        <option value="Sample">Sample</option>
                    </select>
                </div>
            </div>
            <img class ="lectures-png"src="<?= base_url() ?>assets/images/stethoscope.jpg" height="300">
            <div class="container-sm">
                <div class=form-group>
                     <div class="file-field input-field">
                            <div class="btn white">
                                <span>Add Media</span>
                                 <input type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
            </div> 
<!-- ckeditor-->

<head>
        <meta charset="utf-8">
        <title>A Simple Page with CKEditor 4</title>
        <!-- Make sure the path to CKEditor is correct. -->
        <script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>
    </head>
    <body>
        <form>
            <textarea name="editor1" id="editor1" rows="10" cols="80">
                This is my textarea to be replaced with CKEditor 4.
            </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
        </form>

        <div class="container-sm">
                <div class=form-group>
                    <button class="btn white " style="color: black  ;"type="submit">Upload Video</button>
                </div>
            </div>

            <div class="container-sm">
                <div class=form-group>
                    <button class="btn grey darken-2 " style="color: white;"type="submit">Create Video</button>
                </div>
            </div>
        </form>
    </div>

    
</div>
</div>