import {useState} from 'react';
function App() {
 
  {/* pegar os valores clicados no botao */}
  //variaveis para sempre ir atualizando com o que foi digitado em cada botao
  const[calc,setCalc]= useState("");
  const[result,setResult]= useState("");
  var operator="";
  {/* constante para dizer o valor do operador */}
  const ops = ['/','*','+','-','.']

  {/* arrow function onde cada botao representara um valor,quando for clicado esse valor sera usado no calculo.
  Jogando os valores clicados no botao para updatecalc  */}

  {/* arrow function para pegar os valores dos botoes. */}
  const updateCalc =  value => {
    if(ops.includes(value)){
      operator=value;
    }
    if(
        /*
    if 
     Se o ultimo valor é um operador e o calculo nao tem nada ou 
      o operador tem algo e o ulitmo valor tambem é um operador
      retorna e nao faz nada
      Serve para não deixar colocar o operador quando não deve,limita as operacoes
      ex: 12 ++ 
 */
      ops.includes(value) && calc === '' ||
      ops.includes(value) &&  ops.includes(calc.slice(-1))
    ){
      return;
      //retorna e nao permite o erro
    }
    setCalc(calc+value);


  }
  
  {/* arrow function para criar os botoes */}
  const createDigits = () =>{
      {/* array para armazenar os elementos(botoes) */}
      const digits = [];
      {/* gerar os botoes */}
      for(let i = 1;i<8;i++){
        digits.push(
        <button
          onClick = {() => updateCalc(i.toString()) } /*  comvertendo para string para evitar problemas */
          key = {i} >
          {i}
            </button>
        )
      }
      /* retorna o array de botoes */
      return digits;

  }

  //funcao para calcular
  const  calculate = sistema => {
    
    console.log(sistema)
   //descobre qual o operador está em calc
    if(calc.includes("+")){
      operator="+";
    }else if(calc.includes("-")){
      operator="-";
    }else if(calc.includes("*")){
      operator="*";
    }else if(calc.includes("/")){
      operator="/";
    }
   //splita a variavel calc que contem toda a operacao em v1 e v2 alem de converter para o sistema desejado
    var valor= calc.split(operator);
    var valor1=valor[0];
    var valor2=valor[1];
    var valor1n=parseInt(valor1,8)
    var valor2n=parseInt(valor2,8)

    var resultado=eval(valor1n+operator+valor2n);
    console.log(resultado)
    if(sistema!=8){
      resultado = Math.trunc(resultado);
      console.log(resultado)
    }
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
//funcao para enviar o sms com o resultado da conta usando fetch
function enviar(){
  var telefone = prompt("Digite seu numero");
  var url = "https://wapi.appclientefiel.com.br/rest/comum/EnviarWhats/"+telefone +"/Calculadora/" +calc+""
  fetch(url).then((response)=>{
    if(response.status==200){
      alert("Mensagem enviada com sucesso");
    }else{
      alert("Falha ao enviar");
    }
  })
  
  url = ""
}
//organização da calculadora em si
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

        </div>

        <div className='sistemas'>
          <button onClick = {() => calculate('10')}>=Decimal</button>
          <button onClick = {() => calculate('8')}>=Octal</button>
          <button onClick = {() => calculate('2')}>=Binario</button>
        </div>
        
        <div className='enviar'>
        <button onClick = {() => enviar()}>Enviar p WhatsApp</button>
        </div>
        
        </div>
        </div>
  );
}

export default App;
