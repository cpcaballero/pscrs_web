<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>PSCRS  </title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- <link href="<?=base_url()?>assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="<?=base_url()?>assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
   -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" 
  integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="//storage.googleapis.com/code.getmdl.io/1.0.1/material.teal-red.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
   <!--  Scripts-->
   <script src="//storage.googleapis.com/code.getmdl.io/1.0.1/material.min.js"></script>
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="<?=base_url()?>assets/js/materialize.js"></script>
  <script src="<?=base_url()?>assets/js/init.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</head>
<style>
  
body{
  background-image: url("../assets/images/hospitalbg.jpg");
  background-attachment: fixed;
  background-repeat: no-repeat;
  
}
.img{
  height:auto;
  width: 100%;
}
.changepwcard{
height: 350px;
width: 500px;
}

/* Floating column for labels: 25% width */
.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

/* Floating column for inputs: 75% width */
.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}
.form-group{
  margin-top:20px;
}

.full{
  display: block;
  width: 100%;
  font-size: 15px;
  cursor: pointer;
  text-align: center;
}
.textf{
  display: block;
  width: 100%;
 
  
  font-size: 15px;
  cursor: pointer;
  text-align: center;
}

*{
  margin: 0;
  padding: 0;
  font-family: roboto;
}

.input-group{
  position: relative;
}

.input-group .input-area{
  border: 1px solid #dadce0;
  padding: 16px 13px;
  font-size: 18px;
  border-radius: 5px;
}
.input-group .input-area:valid + .label{
  top: -8px;
  padding: 0 3px;
  font-size: 14px;
  color: #8d8d8d;
}
.input-group .input-area:focus{
  border: 2px solid royalblue;

}

.input-group .input-area:focus + .label{
  top: -8px;
  padding: 0 3px;
  font-size:14px;
  color: royalblue;
}
 .noacc{
  position: absolute;
    right: 0;
    padding: 0 16px;
}
.input-group .label{
  color: #dadce0;
  position: absolute;
  top: 20px;
  left: 13px;
  background: #ffffff;
  transition: .2s;
  
}
.sendemail{
  position: absolute;
    top: 40%;
    right: 3px;
    padding: 0 40px;
}
.sendemailcode{
  position: absolute;
    top: 40%;
    left: 1px;
    padding: 0 40px;
}
.sendsmscode{
  position: absolute;
    top: 52%;
    left: 1px;
    padding: 0 40px;
}
.sendsms{
  position: absolute;
    top: 52%;
    right: 10px;
    padding: 0 40px; 
}
.confirmchange{
  position: absolute;
    top: 70%;
    right: 150px;
    padding: 0 40px;
}
.confirmcancel{
  position: absolute;
    top: 70%;
    right: 20px;
    padding: 0 40px;
}
.textcode{
   position: absolute;
    top: 50%;
    right: -30px;
    
}
.code{
    position: absolute;
    top: 50%;
    right: 10px;
    padding: 0 40px;
}
.sentcode{
  position: absolute;
    top: 90%;
    right: 1px;
    padding: 0 40px;
}
.btncode{
  position: absolute;
    top: 450%;
    right: 150px;
    padding: 0 40px;
}
.btncode1{
  position: absolute;
    top: 450%;
    right: 20px;
    padding: 0 40px;
}
</style>

