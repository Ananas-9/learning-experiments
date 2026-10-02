const display = document.getElementById("display");
const v1 = document.getElementById("1");
const v2 = document.getElementById("2");
const calcNum1 = document.getElementById("calcNum1");
const calcResult = document.getElementById("calcResult");
const funkResult = document.getElementById("funkResult");
const a_input=document.getElementById("a");
const b_input=document.getElementById("b");
const c_input=document.getElementById("c");
const x1_input = document.getElementById("x1");
const x2_input = document.getElementById("x2");
const y1_input = document.getElementById("y1");
const y2_input = document.getElementById("y2");
const z1_input = document.getElementById("z1");
const z2_input = document.getElementById("z2");
const VektorResult = document.getElementById("VektorResult");
const VektorOperation = document.getElementById("VektorOperation");

// Показ/приховування інформації про автора
function showAuthorInfo() {
    document.getElementById('authorInfo').style.display = 'block';
}

function hideAuthorInfo() {
    document.getElementById('authorInfo').style.display = 'none';
}

function appendToDisplay(input) {
    display.value += input;
}

function clearDisplay() {
 display.value = "";
}

function calculate() {
    try {
        display.value = eval(display.value)
    } catch (error) {
        display.value = "Помилка";
    }
}
const unitConverter = {
    cm: 0.01,
    dm: 0.1,
    mm: 0.001,
    m: 1,
    km: 1000
};
function veluchuna(){
    calcResult.innerHTML = unitConverter[v1.value]*calcNum1.value/unitConverter[v2.value]
}
function funkanalys(){
    let a = parseFloat(a_input.value);
    let b = parseFloat(b_input.value);
    let c = parseFloat(c_input.value);
    if(a === 0) {
        alert("а має бути відмінним від 0")
        return;
    }
    let ver_x = -b/(2*a);
    let ver_y = a*ver_x*ver_x+b*ver_x+c;
    let D = b*b - 4*a*c;
    if(D>0){
        let x1 = -b-Math.sqrt(D)/2*a;
        let x2 = -b+Math.sqrt(D)/2*a;
        funkResult.innerHTML = `Вітки даної функції направлені ${a>0 ? "вгору" : "вниз"}. Дана функція перетинає Oy в точці (${c}; 0) та Ox в точках (0; ${x1}) (0; ${x2}). Вершина даної параболи знаходиться в (${ver_x}; ${ver_y})`
    }else if(D===0){
        let x = -b/2*a;
        funkResult.innerHTML = `Вітки даної функції направлені ${a>0 ? "вгору" : "вниз"}. Дана функція перетинає Oy в точці (${c}; 0) та Ox в точці (0; ${x}). Вершина даної параболи знаходиться в (${ver_x}; ${ver_y})`
    }else{
        funkResult.innerHTML = `Вітки даної функції направлені ${a>0 ? "вгору" : "вниз"}. Дана функція перетинає Oy в точці (${c}; 0) та не перетинає Ox. Вершина даної параболи знаходиться в (${ver_x}; ${ver_y})`
    }
}
function Vektor(){
    let x1 = parseFloat(x1_input.value);
    let x2 = parseFloat(x2_input.value);
    let y1 = parseFloat(y1_input.value);
    let y2 = parseFloat(y2_input.value);
    let z1 = parseFloat(z1_input.value);
    let z2 = parseFloat(z2_input.value);
    switch (VektorOperation.value){
        case "+":
            VektorResult.innerHTML = `(${x1+x2}; ${y1+y2}; ${z1+z2})`
            break;
        case "-":
            VektorResult.innerHTML = `(${x1-x2}; ${y1-y2}; ${z1-z2})`
            break;
        case "*":
            VektorResult.innerHTML = x1*x2 + y1*y2 + z1*z2
            break;
        case "x":
            VektorResult.innerHTML = `(${y1*z2-z1*y2}; ${z1*x2-x1*z2}; ${x1*y2-x2*y2})`
            break;
    }
}