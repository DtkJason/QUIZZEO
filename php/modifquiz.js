var field = document.getElementById("field");
var nformu = document.getElementById("nformu");
var nformi = document.getElementById("nformi");
var button = document.getElementById("addo");
var x = 1;
let indq = 0;
let count = 1;
// const nbrquest = document.getElementById('demo');


function ajout() {
  const elementQuestion = document.querySelectorAll(".divoq");
  for (let i_quest = 0; i_quest <= elementQuestion.length; i_quest++) {
    indq = i_quest;
  }
  indq++;

  const divo = document.createElement("div");
  divo.className = `divoq divoq${indq}`;

  var br = document.createElement("br");
  const qlabel = document.createElement("label");
  const nqlabel = document.createTextNode(`question n°${indq} `);
  qlabel.appendChild(nqlabel);

  const questio = document.createElement("input");
  questio.type = "text";
  questio.className = `Question${indq}`;
  questio.name = `question${indq}`;
  questio.placeholder = "entre un truc";
  questio.required = true;

  const blabel = document.createElement("label");
  const difflabel = document.createElement("label");
  const nblabel = document.createTextNode(`  - Entrer une reponse: `);
  blabel.appendChild(nblabel);

  const diff = document.createElement("select");
  diff.name = `diffQestion${indq}`;
  const diffop0 = document.createElement("option");
  diffop0.value = "0";
  var t0 = document.createTextNode("...");
  diffop0.appendChild(t0);
  const diffop1 = document.createElement("option");
  diffop1.value = "1";
  var t1 = document.createTextNode("facile");
  diffop1.appendChild(t1);
  const diffop2 = document.createElement("option");
  diffop2.value = "2";
  var t2 = document.createTextNode("intermediarie");
  diffop2.appendChild(t2);
  const diffop3 = document.createElement("option");
  diffop3.value = "3";
  var t3 = document.createTextNode("difficile");
  diffop3.appendChild(t3);

  const rep1n = document.createElement("input");
  rep1n.type = "text";
  rep1n.className = `BRepons${indq}`;
  rep1n.name = `bonnereponse${indq}`;
  rep1n.placeholder = "entre la bonne reponse";
  rep1n.required = true;

  const rep2n = document.createElement("input");
  rep2n.type = "text";
  rep2n.className = `MRepons1-${indq}`;
  rep2n.name = `mauvaisereponse${indq}-1`;
  rep2n.placeholder = "entre une mauvaise reponse";
  rep2n.required = true;

  const rep3n = document.createElement("input");
  rep3n.type = "text";
  rep3n.className = `MRepons2-${indq}`;
  rep3n.name = `mauvaisereponse${indq}-2`;
  rep3n.placeholder = "entre une mauvaise repponse";
  rep3n.required = true;

  const rep4n = document.createElement("input");
  rep4n.type = "text";
  rep4n.className = `MRepons3-${indq}`;
  rep4n.name = `mauvaisereponse${indq}-3`;
  rep4n.placeholder = "entre une mauvaise repponse";
  rep4n.required = true;


  divo.appendChild(br.cloneNode());
  divo.appendChild(qlabel);
  divo.appendChild(br.cloneNode());
  divo.appendChild(questio);
  divo.appendChild(br.cloneNode());
  divo.appendChild(blabel);
  divo.appendChild(br.cloneNode());
  divo.appendChild(difflabel);
  diff.appendChild(diffop0);
  diff.appendChild(diffop1);
  diff.appendChild(diffop2);
  diff.appendChild(diffop3);
  divo.appendChild(diff);
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
  console.log(indq);


}


function remove() {
  var input_tags = field.getElementsByTagName("input");
  if (input_tags.length > 3) {
    field.removeChild(input_tags[input_tags.length - 1]);
  }
}

function suppr() {
  var div_tags = nformi.getElementsByTagName("div");
  if (div_tags.length > 0) {
    nformi.removeChild(div_tags[div_tags.length - 1]);
  }

}

const myModal = document.getElementById("myModal");
const myInput = document.getElementById("myInput");

myModal.addEventListener("shown.bs.modal", () => {
  myInput.focus();
});
