

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../mapingcss/quizz.css">
  <title>Document</title>
</head>
<body>
    <h1>on teste</h1><br>

  <div class="cardo card" >
    <h5 class="card-header"><?php echo $_POST["title"];?></h5>
    <div class="card-body">
      <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6" aria-label="Slide 7"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="7" aria-label="Slide 8"></button>
        </div>
        <div class="carousel-inner yolo">
          <div class="caro carousel-item active "  >
            <div class="cardi  card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item cardu"><?php echo $_POST["question-n1"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["text"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["text"] ; ?></li>
              </ul>
            </div>
          </div>
          <div class="caro carousel-item">
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item cardu"><?php echo $_POST["Question2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["BRepons2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["MRepons1-2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["MRepons2-2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["MRepons3-2"] ; ?></li>
              </ul>
            </div>
          </div>
          <div class="caro carousel-item">
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item cardu"><?php echo $_POST["Question2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["BRepons2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["MRepons1-2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["MRepons2-2"] ; ?></li>
                <li class="list-group-item"><?php echo $_POST["MRepons3-2"] ; ?></li>
              </ul>
            </div>
          </div>
          <div class="caro carousel-item">
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item cardu">An iteqegm</li>
                <li class="list-group-item">A seconqefefd item</li>
                <li class="list-group-item">A thiraefd item</li>
              </ul>
            </div>
          </div>
          <?php for ($i = 1; $i <= 3; $i++) {echo ' <div class="caro carousel-item">
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item cardu">' . $_POST["Question2"] . '</li>
                <li class="list-group-item">'  .$_POST["BRepons2"] . '</li>
                <li class="list-group-item">' . $_POST["MRepons1-2"] . '</li>
                <li class="list-group-item">'  .$_POST["MRepons2-2"] . '</li>
                <li class="list-group-item">'  .$_POST["MRepons3-2"].  '</li>
              </ul>
            </div>
          </div> ';} ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>