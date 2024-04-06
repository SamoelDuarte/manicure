$(".format-proper-user-name").keyup(() => {
    $(".format-proper-user-name").val(Utils.formatProperUsername($(".format-proper-user-name").val()))
})

const _token = $("input[name=_token]").val();
const SPMaskBehavior = function (val) {
    return  "000.000.000-00"
},
spOptions = {
    onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    },
};

const SPMaskBehaviorPhone = function (val) {
    return val.replace(/\D/g, "").length === 11
        ? "(00) 0 0000-0000"
        : "(00) 0000-00009";
},
spOptionsPhone = {
    onKeyPress: function (val, e, field, options) {
        field.mask(
            SPMaskBehaviorPhone.apply({}, arguments),
            options
        );
    },
};

const Utils = {
    init: () => {
        Utils.setGlobalConfig();
    },
    setGlobalConfig: () => {
        $(".global-form").submit(() => {
            Utils.setFormsInProcessingMode();
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": _token,
            },
        });

        $(".toggle-right-bar").click(() => {
            $("body").toggleClass("right-bar-enabled");
        });

        $(".title-case").each((i, el) => {
            $(el).keyup(() => {
                $(el).val(Utils.formatProperPersonName($(el).val()));
            });
        });
        
        $(".cpf-cnpj").each((i, el) => {
            $(el).mask(SPMaskBehavior, spOptions);
        });

        $(".phone").each((i, el) => {
            $(el).mask(SPMaskBehaviorPhone, spOptionsPhone);
        });

        $(".zipcode").each((i, el) => {
            $(el).mask('00.000-000');
        })
    },
    setFormsInProcessingMode: () => {
        $(".submit").html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
        );
        $(".submit").prop("disabled", true);

        setTimeout(() => {
            $(".submit").html(
                `<span class="" role="status" aria-hidden="true">Cadastrar</span>`
            );
            $(".submit").prop("disabled", false);  
        }, 5000);
    },

    formatProperUsername: (str) => {
        return _.deburr(str.replaceAll(" ", "").toLowerCase());
    },

    formatProperPersonName: (text) => {
        text = text.toLowerCase();
        let preps = [
            " De ",
            " Da ",
            " Do ",
            " Dos ",
            " E ",
            " O ",
            " Em ",
            " Ou ",
            " Os ",
            " Das ",
        ];
        text = text.replace(/(^|\s)\S/g, function (t) {
            return t.toUpperCase();
        });
        let capitalizedText = text;
        preps.map((prep) => {
            capitalizedText = capitalizedText.replaceAll(
                prep,
                prep.toLowerCase()
            );
        });
        return capitalizedText;
    },

    mensagem(tipo, mensagem, titulo) {
        return Swal.fire(
            titulo,
            mensagem,
            tipo
        );
    },

    showPassword(el_id, btn_id) {
        let typeIsPassword = $(`#${el_id}`).prop("type") == "password";
        if (typeIsPassword) {
            $(`#${el_id}`).prop("type", "text");
            $(`#${btn_id}`).html(`ocultar`);
            return false;
        }

        //password is already text. set its type to password again
        $(`#${el_id}`).prop("type", "password");
        $(`#${btn_id}`).html(`exibir`);
    },

    redirect: (to) => {
        window.location.href = to;
    },

    bytesToKBytes: (bytes) => {
        return (bytes / 1024).toFixed(2).toString() + "KB";
    },

    getAddress: async (zipcode) => {
        const result = {
            error: false,
            data: null,
        };
        await fetch(`https://viacep.com.br/ws/${zipcode}/json/`)
            .then(async (data) => {
                let response = await data.json();
                result.data = response.erro ? null : response;
            })
            .catch((error) => {
                result.error = error;
            });

        return result;
    },
    uuid: () => {
        let dt = new Date().getTime();
        let uuid = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
            /[xy]/g,
            function (c) {
                var r = (dt + Math.random() * 16) % 16 | 0;
                dt = Math.floor(dt / 16);
                return (c == "x" ? r : (r & 0x3) | 0x8).toString(16);
            }
        );
        return uuid;
    },
    removeElement: (elId) => {
        $(elId).remove();
    },
    setupPagination: (data) => {
        const links = Utils.sanitizeLinks(data.data);

        $("#pagination").html(`
        <nav aria-label="Page navigation example">
           <ul class="pagination">
              ${links
                  .map((link) =>
                      `
                 <li style="cursor: pointer" class="page-item ${
                     link.active ? "active" : ""
                 } ${link.page ? "" : "disabled"}">
                    <a class="page-link" ${
                        link.page ? "" : "disabled"
                    } onclick="${data.get}({page: ${link.page}})">${
                          link.label
                      }</a>
                 </li>
              `.trim()
                  )
                  .join("")}
           </ul>
        </nav>
        
        `);
    },
    sanitizeLinks: (data) => {
        let sanitezedLinks = [];
        sanitezedLinks.push({
            active: false,
            page: data.first_page_url
                ? data.first_page_url.split("page=")[1]
                : null,
            label: "Primeira",
        });
        data.links.map((value, i) => {
            if (i == 0) {
                value.label = "&laquo;";
            }
            if (i == data.links.length - 1) {
                value.label = "&raquo;";
            }
            let page = value.url ? value.url.split("page=")[1] : null;
            sanitezedLinks.push({
                active: value.active,
                page: page,
                label: value.label,
            });
        });

        sanitezedLinks.push({
            active: false,
            page: data.last_page_url
                ? data.last_page_url.split("page=")[1]
                : null,
            label: "Última",
        });
        return sanitezedLinks;
    },
    isLoading: (show = true) => {
        if (show) {
            $("#is-loading").css("display", "flex");
            return false;
        }
        $("#is-loading").css("display", "none");
    },
    fileToBase64: (file) =>
        new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        }),
};

Utils.init();

$(document).ready(() => {
    $(".money").mask("000.000.000.000.000,00", { reverse: true });
});

function buscarCEP() {
    const cepInput = document.getElementById('cep');
    const cep = cepInput.value;
    
    
    if (cep.length === 8) {
      
        const viaCepUrl = `https://viacep.com.br/ws/${cep}/json/`;

     
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
          
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {

                    const data = JSON.parse(xhr.responseText);
                    if(data.erro){
                        limparCampos();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                          })
                          
                          Toast.fire({
                            icon: 'error',
                            title: 'Cep não encontrado'
                          })
                    }else{
                        preencherCampos(data);
                    }
                   
                } else {
                    console.error('Erro na consulta ao ViaCEP:', xhr.status);
                    limparCampos();
                }
            }
        };

        xhr.open('GET', viaCepUrl, true);
        xhr.send();
    }
}

function preencherCampos(data) {
    
        document.getElementById('logradouro').value = data.logradouro;
        document.getElementById('bairro').value = data.bairro;
        document.getElementById('cidade').value = data.localidade;
        document.getElementById('estado').value = data.uf;
    
  
}

function limparCampos() {
    document.getElementById('logradouro').value = '';
    document.getElementById('bairro').value = '';
    document.getElementById('cidade').value = '';
    document.getElementById('estado').value = '';
}
