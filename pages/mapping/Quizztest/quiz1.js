var field = document.getElementById('field');
var nformu = document.getElementById('nformu');
var nformi = document.getElementById('nformi');
var button = document.getElementById('addo');
var x = 1;
let indq = 1;
let count = 1;
// const nbrquest = document.getElementById('demo');


function addquest(){
  var button = document.getElementById('addo');
  button.addEventListener('click', function() {
    x++ ;
  });
  
  
  var newForm = document.createElement('form');
  newForm.setAttribute('id',  );

  
 
  nformu.appendChild(newForm);

      var nfifi = document.getElementsById(x);
        var nfifi = document.createElement('input');
        nfifi.setAttribute('type','text');
        nfifi.setAttribute('name','text');
        nfifi.setAttribute('class','text');
        nfifi.setAttribute('siz',50);
        nfifi.setAttribute('placeholder','Optional Field');
        
        (x).appendChild(nfifi);
        var br = document.createElement("br");
        
        
        const elementQuestion = document.querySelectorAll('.DivQuestion')

}

function ajout(){

  const elementQuestion = document.querySelectorAll('.divoq')
        for(let i_quest=1; i_quest<=elementQuestion.length; i_quest++){
            indq = i_quest
        }
        indq++
  

  const divo = document.createElement('div');
  divo.className = `divoq divoq${indq}`;
  
  var br = document.createElement('br');
  const qlabel = document.createElement("label")
    const nqlabel = document.createTextNode(`question n°${indq} `)
  qlabel.appendChild(nqlabel)


  const questio = document.createElement('input');
        questio.type = 'text';
        questio.className = `Question${indq}`;
        questio.name = `Question${indq}`;
        questio.placeholder = 'entre un truc';
        questio.required = true;

  
  const blabel = document.createElement("label")
    const nblabel = document.createTextNode(`  - Entrer une reponse: `)
  blabel.appendChild(nblabel)
    
  const rep1n = document.createElement('input');
        rep1n.type = 'text';
        rep1n.className = `BRepons${indq}`;
        rep1n.name = `BRepons${indq}`;
        rep1n.placeholder = 'entre la bonne reponse';
        rep1n.required = true;

        const rep2n = document.createElement('input');
        rep2n.type = 'text';
        rep2n.className = `MRepons1-${indq}`;
        rep2n.name = `MRepons1-${indq}`;
        rep2n.placeholder = 'entre une mauvaise reponse';
        rep2n.required = true;

        const rep3n = document.createElement('input');
        rep3n.type = 'text';
        rep3n.className = `MRepons2-${indq}`;
        rep3n.name = `MRepons2-${indq}`;
        rep3n.placeholder = 'entre une mauvaise repponse';
        rep3n.required = true;

        const rep4n = document.createElement('input');
        rep4n.type = 'text';
        rep4n.className = `MRepons3-${indq}`;
        rep4n.name = `MRepons3-${indq}`;
        rep4n.placeholder = 'entre une mauvaise repponse';
        rep4n.required = true;

        // const repn = document.createElement('input');
        // repn.type = 'text';
        // repn.className = `Repons${indq}`;
        // repn.name = `Repons${indq}`;
        // repn.placeholder = 'entre un truc';
        // repn.required = true;
 


        divo.appendChild(br.cloneNode());
        divo.appendChild(qlabel);
        divo.appendChild(br.cloneNode());
        divo.appendChild(questio);
        divo.appendChild(br.cloneNode());
        divo.appendChild(blabel);
        divo.appendChild(br.cloneNode());
        divo.appendChild(rep1n);
        divo.appendChild(br.cloneNode());
        divo.appendChild(rep2n);
        divo.appendChild(br.cloneNode());
        divo.appendChild(rep3n);
        divo.appendChild(br.cloneNode());
        divo.appendChild(rep4n);
        divo.appendChild(br.cloneNode());
  nformi.appendChild(divo);
  console.log(indq)

        // count++;
        // document.getElementById('demo').value = count;

}

function add(){

  
  let x = 1;
  var br = document.createElement('br');
  var newField = document.createElement('input');
  newField.setAttribute('type','text');
  newField.setAttribute('name','text');
  newField.setAttribute('class','text');
  newField.setAttribute('siz',50);
  newField.setAttribute('placeholder','Optional Field');
  
 
  
  field.appendChild(newField);
  field.appendChild(br.cloneNode());
   
  
}

function remove(){
  var input_tags = field.getElementsByTagName('input');
  if(input_tags.length > 3) {
    field.removeChild(input_tags[(input_tags.length) - 1]);
  }
}

function suppr(){
  var div_tags = nformi.getElementsByTagName('div');
  if(div_tags.length > 0 )  {
    nformi.removeChild(div_tags[(div_tags.length) - 1]);
  }

  // count--;
  // document.getElementById('demo').value = count;
 
}

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus();
})