@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
    
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">
    
        {{-- Preloader Animation (fullscreen mode) --}}
        @if($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif



<button id="btnChatbot" type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#chatbotModal">
  <i class="fas fa-robot"></i> Chatbot
</button>

<!-- Modal Chatbot -->

<!-- Modal Chatbot -->
<div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-sm" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chatbotModalLabel">Chatbot</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div id="chatbotContent" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
          <p><strong>Bot:</strong> Bienvenido al chatbot, ¿en qué puedo ayudarte?</p>
        </div>
      </div>
      <div class="modal-footer">
        <input type="text" id="chatInput" class="form-control" placeholder="Escribe tu mensaje..." autocomplete="off" />
      </div>
    </div>
  </div>
</div>




    </div>


@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')

    @if( (($mensaje = Session::get('mensaje')) &&  ($icono = Session::get('icono'))) )
        <script>
                Swal.fire({
                position: "top-end",
                icon: "{{ $icono }}",
                title: "{{ $mensaje }}",
                showConfirmButton: false,
                timer: 4000
        });
            </script>
    @endif

<!-- AWS SDK -->
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1482.0.min.js"></script>

<script>


function appendMessage(sender, text) {
  const content = document.getElementById('chatbotContent');
  const div = document.createElement('div');
  div.className = sender === 'Bot' 
    ? 'bg-cyan-100 text-cyan-800 p-3 rounded-lg shadow-sm w-fit max-w-[85%]' 
    : 'bg-cyan-600 text-white p-3 rounded-lg shadow-sm self-end w-fit max-w-[85%] ml-auto';
  div.textContent = `${sender}: ${text}`;
  content.appendChild(div);
  content.scrollTop = content.scrollHeight;
}

  // 🧭 Configuración AWS
  AWS.config.region = 'us-east-1';
  AWS.config.credentials = new AWS.CognitoIdentityCredentials({
    IdentityPoolId: 'us-east-1:9ff5f177-5a16-4b02-9deb-45d69c807ddc'
  });

  const lexRuntime = new AWS.LexRuntimeV2();
  const translate = new AWS.Translate();

  const botId = 'XHS8TMSJZL';
  const botAliasId = 'TSTALIASID';
  const localeId = 'en_US';
  const sessionId = 'user-' + Date.now();

  // 🧠 Enviar mensaje al presionar ENTER
  document.getElementById('chatInput').addEventListener('keypress', async function (e) {
    if (e.key === 'Enter') {
      const inputText = e.target.value.trim();
      if (!inputText) return;
      appendMessage('Tú', inputText);
      e.target.value = '';
      await enviarMensajeTraducido(inputText);
    }
  });

  // 🖋️ Mostrar mensaje
  function appendMessage(sender, text) {
    const content = document.getElementById('chatbotContent');
    const p = document.createElement('p');
    p.innerHTML = `<strong>${sender}:</strong> ${text}`;
    content.appendChild(p);
    content.scrollTop = content.scrollHeight;
  }

  // 🔁 Traducir usando Amazon Translate
  async function traducirAWS(texto, sourceLang, targetLang) {
    return new Promise((resolve, reject) => {
      const params = {
        SourceLanguageCode: sourceLang,
        TargetLanguageCode: targetLang,
        Text: texto
      };
      translate.translateText(params, function (err, data) {
        if (err) {
          console.error("Error con AWS Translate:", err);
          reject(err);
        } else {
          resolve(data.TranslatedText);
        }
      });
    });
  }

  // 🤖 Traducir y enviar mensaje a Lex
  async function enviarMensajeTraducido(textoUsuario) {
    try {
      const textoIngles = await traducirAWS(textoUsuario, 'es', 'en');

      const params = {
        botId,
        botAliasId,
        localeId,
        sessionId,
        text: textoIngles
      };

      lexRuntime.recognizeText(params, async function (err, data) {
        if (err) {
          console.error(err);
          appendMessage('Bot', '⚠️ Error al contactar con el asistente.');
        } else {
          const respuestaIngles = data.messages?.[0]?.content || '(Sin respuesta)';
          const respuestaEsp = await traducirAWS(respuestaIngles, 'en', 'es');
          appendMessage('Bot', respuestaEsp);
        }
      });
    } catch (error) {
      appendMessage('Bot', '⚠️ Error al traducir o procesar el mensaje.');
    }
  }
</script>



<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1482.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>




@stop
