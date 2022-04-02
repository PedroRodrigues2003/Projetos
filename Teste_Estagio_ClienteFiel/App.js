import {useState} from 'react';
function App() {
 
  {/* pegar os valores clicados no botao */}
  const[calc,setCalc]= useState("");
  const[result,setResult]= useState("");
  var operator="";
  {/* constante para dizer o valor do operador */}
  const ops = ['/','*','+','-','.']

  {/* arrow function onde cada botao representara um valor,quando for clicado esse valor sera usado no calculo.
  Jogando os valores clicados no botao para updatecalc  */}

  {/*
    if 
     Se o ultimo valor é um operador e o calculo nao tem nada ou 
      o operador tem algo e o ulitmo valor tambem é um operador
      retorna e nao faz nada
      Serve para não deixar colocar o operador quando não deve,limita as operacoes
      ex: 12 ++ 
 */}
  {/* arrow function para pegar os valores dos botoes */}
  const updateCalc =  value => {
    if(ops.includes(value)){
      operator=value;
    }
    if(
      ops.includes(value) && calc === '' ||
      ops.includes(value) &&  ops.includes(calc.slice(-1))
    ){
      return;
    }
    setCalc(calc+value);
    console.log(calc);
     {/* se o ultimo item nao for um operador ou um valor */}
      {/* eval realiza qualquer operacao passada na string */}

  }
  
  {/* arrow function para criar os botoes */}
  const createDigits = () =>{
      {/* array para armazenar os elementos(botoes) */}
      const digits = [];
      {/* gerar os botoes */}
      {/*  comvertendo para string para evitar problemas */}
      for(let i = 1;i<8;i++){
        digits.push(
        <button
          onClick = {() => updateCalc(i.toString()) } 
          key = {i} >
          {i}
            </button>
        )
      }
      {/* retorna o array de botoes */}
      return digits;

  }
  const  calculate = sistema => {
    console.log(calc);
    if(calc.includes("+")){
      operator="+";
    }else if(calc.includes("-")){
      operator="-";
    }else if(calc.includes("*")){
      operator="*";
    }else if(calc.includes("/")){
      operator="/";
    }
    //console.log(operator);
    var valor= calc.split(operator);
    var valor1=valor[0];
    var valor2=valor[1];
    var resultado=eval(valor1.toString(sistema)+operator+valor2.toString(sistema));
    setCalc(resultado.toString(sistema));
}

   {/* funcao pra delete
   quando calc nao estiver vazio,é so voltar 1
   */}
  const  deleteLast = () => {
    if(calc == ''){
      return
    }
    const value = calc.slice(0,-1);
    setCalc(value);
}
function enviar(){
  var telefone = prompt("Digite seu numero");
  var url = "https://wapi.appclientefiel.com.br/rest/comum/EnviarWhats/"+ telefone +"/Calculadora/" +calc+""
  document.write(url);
  fetch(url).then((response)=>{
    if(response.status==200){
      alert("Mensagem enviada com sucesso")
    }else{
      alert("Falha ao enviar")
    }
  })
  
  url = ""
}
  return (
    <div className="App">
      <div className="calculator">

        <div className="display">

        {calc || "0 "}

        </div>

        
  
        {/* operadores */}
        {/* cada botao sera um arrow function que dirá updateCalc */}
        <div className="operators">

<button onClick = {() => updateCalc('/')}>/</button>
<button onClick = {() => updateCalc('*')}>*</button>
<button onClick = {() => updateCalc('+')}>+</button>
<button onClick = {() => updateCalc('-')}>-</button>

<button onClick={deleteLast}>DEL</button>

</div>

{/* DIGITOS */}
<div className="digits">
<button onClick = {() => updateCalc('1')}>1</button>
<button onClick = {() => updateCalc('2')}>2</button>
<button onClick = {() => updateCalc('3')}>3</button>
<button onClick = {() => updateCalc('4')}>4</button>
<button onClick = {() => updateCalc('5')}>5</button>
<button onClick = {() => updateCalc('6')}>6</button>
<button onClick = {() => updateCalc('7')}>7</button>
<button onClick = {() => updateCalc('0')}>0</button>


<button onClick = {() => updateCalc('0')}>0</button>


{/* chamando a func calcular */}

<button onClick = {() => calculate('10')}>=Decimal</button>
<button onClick = {() => calculate('8')}>=Octal</button>
<button onClick = {() => calculate('2')}>=Binario</button>
<button onClick = {() => enviar()}>Enviar resultado ao whatssap</button>

</div>

</div>
</div>
  );
}

export default App;