$( "#loginValidation" ).validate({
  rules: {
    email: {
      required: true,
      email: true,
    },  
    senha:{
      required: true,
    }
  },
  messages: {
    email: {
      required: "Este campo é obrigatório",
      email: "Por favor, digite um e-mail vádido",
    },
    senha: {
      required: "Este campo é obrigatório",
    }
  }
});

$( "#cadastrarValidation" ).validate({
	rules: {
		nome: {
			required: true,		
	  },
	  email: {
			required: true,
 			email: true,
	  },
    senha:{
    	required: true,
    },
    confirma:{
    	required: true,
    	equalTo: "#senha",
    },
    celular:{
    	required: true,
    	celular:true,
    },
    cpf:{
    	required: true,
    	cpfBR : true,
    },
    'dt-nasc':{
    	required: true,
    	dateBR : true,
    },
    animal:{
    	required: true,
    },
    tipo:{
    	required: true,
    },
    raca:{

    },
    'dt-nasc-animal':{
    	dateBR : true,
    },
	},
	messages:{
		nome: {
			required: "Este campo é obrigatório",		
		},
		email: {
  			required: "Este campo é obrigatório",
   			email: "Por favor, digite um e-mail vádido",
		},
    senha:{
    	required: "Este campo é obrigatório",
    },
    confirma:{
    	required: "Este campo é obrigatório",
    	equalTo: "Os campos de senha devem ser iguais",
    },
    celular:{
    	required: "Este campo é obrigatório",
    	celular:"Número de celular inválido",
    },
    cpf:{
    	required: "Este campo é obrigatório",
    	cpfBR : "CPF inválido",
    },
    'dt-nasc':{
    	required: "Este campo é obrigatório",
    	dateBR : "Data inválida! Digite no formato dd/mm/aaaa",
    },
    animal:{
    	required: "Este campo é obrigatório",
    },
    tipo:{
    	required: "Este campo é obrigatório",
    },
    raca:{

    },
    'dt-nasc-animal':{
    	dateBR : "Data inválida! Digite no formato dd/mm/aaaa",
    },
	}
});

$( "#editarValidation" ).validate({
  rules: {
    nome: {
      required: true,   
    },
    email: {
      required: true,
      email: true,
    },
    senha:{
      required: true,
    },
    confirma:{
      required: true,
      equalTo: "#senha",
    },
    celular:{
      required: true,
      celular:true,
    },
    cpf:{
      required: true,
      cpfBR : true,
    },
    'dt-nasc':{
      required: true,
      dateBR : true,
    },
    animal:{
      required: true,
    },
    tipo:{
      required: true,
    },
    raca:{

    },
    'dt-nasc-animal':{
      dateBR : true,
    },
  },
  messages:{
    nome: {
      required: "Este campo é obrigatório",   
    },
    email: {
      required: "Este campo é obrigatório",
      email: "Por favor, digite um e-mail vádido",
    },
    senha:{
      required: "Este campo é obrigatório",
    },
    confirma:{
      required: "Este campo é obrigatório",
      equalTo: "Os campos de senha devem ser iguais",
    },
    celular:{
      required: "Este campo é obrigatório",
      celular:"Número de celular inválido",
    },
    cpf:{
      required: "Este campo é obrigatório",
      cpfBR : "CPF inválido",
    },
    'dt-nasc':{
      required: "Este campo é obrigatório",
      dateBR : "Data inválida! Digite no formato dd/mm/aaaa",
    },
    animal:{
      required: "Este campo é obrigatório",
    },
    tipo:{
      required: "Este campo é obrigatório",
    },
    raca:{

    },
    'dt-nasc-animal':{
      dateBR : "Data inválida! Digite no formato dd/mm/aaaa",
    },
  }
});

$( "#animalValidation" ).validate({
  rules: {
    animal:{
      required: true,
    },
    tipo:{
      required: true,
    },
    raca:{

    },
    'dt-nasc-animal':{
      dateBR : true,
    },
    cliente:{
      required : true,
    },
  },
  messages:{
    animal:{
      required: "Este campo é obrigatório",
    },
    tipo:{
      required: "Este campo é obrigatório",
    },
    raca:{

    },
    'dt-nasc-animal':{
      dateBR : "Data inválida! Digite no formato dd/mm/aaaa",
    },
    cliente:{
      required : "Este campo é obrigatório",
    },
  }
});

$( "#animalEditValidation" ).validate({
  rules: {
    animal:{
      required: true,
    },
    tipo:{
      required: true,
    },
    raca:{

    },
    'dt-nasc-animal':{
      dateBR : true,
    },
  },
  messages:{
    animal:{
      required: "Este campo é obrigatório",
    },
    tipo:{
      required: "Este campo é obrigatório",
    },
    raca:{

    },
    'dt-nasc-animal':{
      dateBR : "Data inválida! Digite no formato dd/mm/aaaa",
    },
  }
});

$( "#servicoValidation" ).validate({
  rules: {
    nome:{
      required: true,
    },
    descricao:{
      required: true,
    },
    preco:{
      required: true,
      money : true,
    },
    upload:{
      required: true,
    },
  },
  messages:{
    nome:{
      required: "Este campo é obrigatório",
    },
    descricao:{
      required: "Este campo é obrigatório",
    },
    preco:{
      required: "Este campo é obrigatório",
      money: "Preço inválido. Use o formato 999,99"
    },
    upload:{
      required: "Você deve fazer o upload de uma imagem",
    },

  }

});

$( "#servicoEditValidation" ).validate({
  rules: {
    nome:{
      required: true,
    },
    descricao:{
      required: true,
    },
    preco:{
      required: true,
      money : true,
    },
  },
  messages:{
    nome:{
      required: "Este campo é obrigatório",
    },
    descricao:{
      required: "Este campo é obrigatório",
    },
    preco:{
      required: "Este campo é obrigatório",
      money: "Preço inválido. Use o formato 999,99",
    },
  }
});

//Função para a validação de moeda; permite o formato 999,99
$.validator.addMethod("money", function(value, element) {
  var isValidMoney = /^\d{0,3}\,\d{2}?$/.test(value);
  return this.optional(element) || isValidMoney;
},"Insert ");

//Função para a validação de data; permite o formato dd/mm/aaaa
$.validator.addMethod("dateBR", function(value, element) {
  if(value == "") 
    return true;

  if(value.length!=10) 
    return false;

  //Verificando data
  var data     = value;
  var dia      = data.substr(0,2);
  var barra1   = data.substr(2,1);
  var mes      = data.substr(3,2);
  var barra2   = data.substr(5,1);
  var ano      = data.substr(6,4);

  if(data.length!=10||barra1!="/"||barra2!="/"||isNaN(dia)||isNaN(mes)||isNaN(ano)||dia>31||mes>12)
    return false;
  if((mes==4||mes==6||mes==9||mes==11) && dia==31)
    return false;
  if(mes==2  &&  (dia>29||(dia==29 && ano%4!=0)))
    return false;
  if(ano < 1900)
    return false;
  return true;
}, "Informe uma data válida");


//Função para a validação de CPF
$.validator.addMethod("cpfBR", function(value) {
  if(value == "") return true;
  // Removing special characters from value
  value = value.replace(/([~!@#$%^&*()_+=`{}\[\]\-|\\:;'<>,.\/? ])+/g, "");

  // Checking value to have 11 digits only
  if (value.length !== 11) {
    return false;
  }

  var sum = 0,
  firstCN, secondCN, checkResult, i;

  firstCN = parseInt(value.substring(9, 10), 10);
  secondCN = parseInt(value.substring(10, 11), 10);

  checkResult = function(sum, cn) {
    var result = (sum * 10) % 11;
    if ((result === 10) || (result === 11)) {result = 0;}
      return (result === cn);
  };

  // Checking for dump data
  if (value === "" ||
    value === "00000000000" ||
    value === "11111111111" ||
    value === "22222222222" ||
    value === "33333333333" ||
    value === "44444444444" ||
    value === "55555555555" ||
    value === "66666666666" ||
    value === "77777777777" ||
    value === "88888888888" ||
    value === "99999999999"
  ) {
    return false;
  }

  // Step 1 - using first Check Number:
  for ( i = 1; i <= 9; i++ ) {
    sum = sum + parseInt(value.substring(i - 1, i), 10) * (11 - i);
  }

  // If first Check Number (CN) is valid, move to Step 2 - using second Check Number:
  if ( checkResult(sum, firstCN) ) {
    sum = 0;
    for ( i = 1; i <= 10; i++ ) {
      sum = sum + parseInt(value.substring(i - 1, i), 10) * (12 - i);
    }
    return checkResult(sum, secondCN);
  }
  return false;

}, "Informe um cpf válido, campo obrigatório");
    
    
//Função para a validação de número de celular nos formatos: 99888887777  9988887777 (99)888887777  (99)88887777
jQuery.validator.addMethod('celular', function (value, element) {
    value = value.replace("(","");
    value = value.replace(")", "");
    value = value.replace("-", "");
    value = value.replace(" ", "").trim();
    if (value == '0000000000') {
        return (this.optional(element) || false);
    } else if (value == '00000000000') {
        return (this.optional(element) || false);
    } 
    if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"].indexOf(value.substring(0, 2)) != -1) {
        return (this.optional(element) || false);
    }
    if (value.length < 10 || value.length > 11) {
        return (this.optional(element) || false);
    }
    if (["6", "7", "8", "9"].indexOf(value.substring(2, 3)) == -1) {
        return (this.optional(element) || false);
    }
    return (this.optional(element) || true);
}, 'Informe um celular válido');

//Função para a validação de número de telefone fixo
jQuery.validator.addMethod('telefone', function (value, element) {
  value = value.replace("(", "");
  value = value.replace(")", "");
  value = value.replace("-", "");
  value = value.replace(" ", "").trim();
  if (value == '0000000000') {
    return (this.optional(element) || false);

  } else if (value == '00000000000') {
    return (this.optional(element) || false);

  }
  if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"].indexOf(value.substring(0, 2)) != -1) {
    return (this.optional(element) || false);
  }

  if (value.length < 10 || value.length > 11) {
    return (this.optional(element) || false);
  }

  if (["1", "2", "3", "4","5"].indexOf(value.substring(2, 3)) == -1) {
    return (this.optional(element) || false);
  }
  
  return (this.optional(element) || true);
}, 'Informe um telefone válido'); 