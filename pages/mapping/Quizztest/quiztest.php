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
    <h1>quizz page</h1>

    <h2>Q U I Z Z Z Z Z</h2><br>

    <!-- Button trigger modal -->

  <div class="cardo card w-50" >
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        click to add a quizz
      </button><br>
    </div>
  </div>
  
  <!-- Modal -->
  <div class="modo modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modoh modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">New Quizz</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modob modal-body">
            <div class="divoq divoq1">
                <form method="POST" action="recupquizz.php">
                    <div id="field">
                        <label>Title</label>
                        <input type="text" name="title" required=""> <br><br>
                        <label>Question</label><br>
                        <input type="text" name="question-n1" required=""> <br>
                        <label>Reponse</label><br>
                        <input id="rep" type="text" name="text" class="text"  placeholder="entrer une reponse"><br>
                        <label>nombre de question</label>
                        <input  type="text" id="dezmo" name="nqu" required=""> <br>
                    </div>
                    <br>
                  <span>autre question</span>
                  <button class="ajout"  onclick="ajout()">Ajout une question</button>
                  <div id="nformi">
                  </div>
                  <input type="submit" name="" id="" value="submit"><br>
                  <!-- <input id="demo" type="text" name="demo">1</input> <span id="demo" name="counter"  value= 1 ></span> --> 
                    
                </form>
                

                <div id="nformu">
                </div>
            </div>
            <div>
               
                <div class="controls">
                    <button class="add"  onclick="add()">Ajoute une reponse</button>
                    <button class="remove" onclick="remove()">suppr une reponse</button>
                    <!-- <button class="addquest" id="addo" onclick="addquest()">add question</button> -->
                  </div><br>
                  <div class="controlss">
                    
                    <button class="suppr" onclick="suppr()">suppr les question</button>
                  </div>
                  
            </div>
        </div>
        <div class="modof modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div><br><br>


  <div class="cardo card" >
    <h5 class="card-header">Featured</h5>
    <div class="card-body">
      <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner yolo">
          <div class="caro carousel-item active "  >
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third itemaedfdqqqs
                </li>
              </ul>
            </div>
          </div>
          <div class="caro carousel-item">
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item">An iteqegm</li>
                <li class="list-group-item">A seconqefefd item</li>
                <li class="list-group-item">A thiraefd item</li>
              </ul>
            </div>
          </div>
          <div class="caro carousel-item">
            <div class="cardi card" >
              <ul class="list-group list-group-flush">
                <li class="list-group-item">An iteqegm</li>
                <li class="list-group-item">A seconqefefd item</li>
                <li class="list-group-item">A thiraefd item</li>
              </ul>
            </div>
          </div>
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
  

  
    

    <!-- <div class="divoq divoq1">
        <form>
            <div id="field">
                <label>Title</label>
                <input type="text" name="title" required=""> <br><br>
                <label>Question</label><br>
                <input type="text" name="question n°1" required=""> <br>
                <label>Reponse</label><br>
                <input id="rep" type="text" name="text" class="text"  placeholder="entrer une reponse"><br>
                <input type="radio" name="bad" required="" placeholder="entrer une mauvaise reponse"> <br>
            </div>
        </form>
        <div id="nformu">
        </div>
    </div>
    <div>
       
        <div class="controls">
            <button class="add"  onclick="add()">Ajoute une reponse</button>
            <button class="remove" onclick="remove()">suppr une reponse</button>
            <button class="addquest" id="addo" onclick="addquest()">add question</button>   aez²&rté"'()'
          </div><br><br>
          <span>autre question</span>
          <div id="nformi">
          </div>
          <div class="controlss">
            <button class="ajout"  onclick="ajout()">Ajout une question</button>
            <button class="suppr" onclick="suppr()">suppr les question</button>
          </div>
          <p>il y a  : <span id="demo"> </span>  question</p>
    </div> --> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  
    <script src="quiz1.js"></script>
</body>
</html>