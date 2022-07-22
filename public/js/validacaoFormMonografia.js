//Validação simples
("#formCadastroTcc").validate({
    rules: {
        pessoaDupla: {
            required: (function () { 
                            if (dupla.val().length > 0) { return true; } else { return false; } 
                        })
        },
        orientador_id: {
            required: true
        },
        titulo: {
            required: true,
            minlength: 5,
            maxlength: 255
        },
        resumo: {
            required: true,
            max: 5000
        },
        unitermo1: {
            required:true
        },
        unitermo2: {
            required:true
        },
        unitermo3: {
            required:true
        }
      },
      messages :{
        pessoaDupla: {
            accept: "Informe o companheiro(a) de turma."
        },
        titulo: {
            accept: "Informe o título, deve ter no máximo 255 caracteres."
        },
        resumo: {
            acceptt: "Informe o resumo do trabalho. Deve conter no mínimo 500 palavras."
        },
        orientador_id: {
            accept: "Informe o Orientador Principal"
        },
        unitermo1: {
            accept: "Informe o Unitermo 1"
        },
        unitermo2: {
            accept: "Informe o Unitermo 2"
        },
        unitermo3: {
            accept: "Informe o Unitermo 3"
        }
      }
});