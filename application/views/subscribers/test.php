<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PSCRS </title>

  <!-- CSS  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>


<body>
  <main>
    <div class="container-fluid">
      <div class="row">

        <div class="col s12">

          <div class="col s12 ">
            <h5><strong>Marketplace</strong>
          </div>


          <div class="row">
            <div class="col s5">
              <div class="card">
                <div class="card-image">
                  <div class="carousel carousel-slider center ">
                    <div class="carousel-item red white-text" href="#one!">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP_dWz6ud9B6BOZJCTMlsVm87e8F3acNDgSg&usqp=CAU" alt="" class="responsive-img">
                    </div>
                    <div class="carousel-item amber white-text" href="#two!">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP_dWz6ud9B6BOZJCTMlsVm87e8F3acNDgSg&usqp=CAU" alt="" class="responsive-img">
                    </div>
                    <div class="carousel-item green white-text" href="#three!">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP_dWz6ud9B6BOZJCTMlsVm87e8F3acNDgSg&usqp=CAU" alt="" class="responsive-img">
                    </div>
                    <div class="carousel-item blue white-text" href="#four!">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP_dWz6ud9B6BOZJCTMlsVm87e8F3acNDgSg&usqp=CAU" alt="" class="responsive-img">
                    </div>
                  </div>
                </div>
                <div class="card-content">
                  <h5><strong>Item Name</strong> &emsp;₱ 1,990.00</h5>
                  <h6><strong>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                      Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                      galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also
                      the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
                      release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                      like Aldus PageMaker including versions of Lorem Ipsum.</strong></h6>
                  <br>

                  <input type="number" id="available_stocks" name="available_stocks" class="validate">
                  <label for="available_stocks" data-error="wrong" data-success="right">Quantity</label>

                  <div class="input-field">
                    <select>
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">Paymaya</option>
                      <option value="2">Over the counter</option>
                    </select>
                    <label>Mode of Payment</label>
                  </div>

                  <input type="text" id="available_stocks" name="available_stocks" class="validate" disabled>
                  <label for="available_stocks" data-error="wrong" data-success="right">Total</label>
                </div>
                <div class="card-action">
                  <a class="btn btn-small grey darken-2 white-text" href="#"><small>Buy now</small></a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
  </main>
</body>


<script>
  $('.carousel.carousel-slider').carousel({
            fullWidth: true,
            indicators: true
        });
</script>
</body>

</html>