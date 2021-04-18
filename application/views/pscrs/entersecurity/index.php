
<main> 
<div style="margin: 30px;">
    <div class="container" >
       
        <div  class= " col align-self-center">
        <div class= " col-md-5 col align-self-center offset-md-1 mx-auto">

            <div class="shadow p-3 mb-5 bg-white rounded card horizontal">
        <div class="card-content" style="background-color: #ffffff; height: 18rem;">
            <form action="<?= base_url() ?>User/login" method="post">
            <div class="card-body">
           <h5 class="card-title">Enter Security Code</h5>
           
      
            
            <label class="form-check-label" for="">
                Please check your email for a message with your code, Your code is 6 number long. 
            </label>
          
            <div class ="input-group textcode">
            <div style="margin:2px;">
                <input type ="text" id="inputfield" style="width: 10rem;"required class="input-area">
                <label for ="inputfield" class="label">Enter Code</label>
            </div>
            </div>
            <div class ="code">
            <label class="form-check-label" for="">
               We sent your code  to:
            </label>

           
            <div class ="sentcode">
            <label class="form-check-label" for="">
               ###########
            </label> 
            <div>
            </div>  


            <a href="#" class="btn btn-primary btncode">Confirm</a>
            <a href="#" class="btn btn-outline-primary btncode1">cancel</a>
            </form>
            
             </div>
            </div>
         </div>


    </div>
    </div>
</div>

</main>