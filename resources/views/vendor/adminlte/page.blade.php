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
<script>


const respuestasLocales = {
    "hola": "¡Hola! ¿En qué puedo ayudarte?",
    "ayuda": "Puedo ayudarte con usuarios, productos, roles y permisos. Intenta preguntar sobre eso."
  };

 
  const contextoBase = [
    { role: "system", content: "Eres un asistente útil para un sistema de ventas." },
    { role: "system", content: "Si alguien pregunta 'crear usuario', responde: Para crear un usuario, ve al menú 'Usuarios' y haz clic en 'Crear Usuario'." },
    { role: "system", content: "Si alguien pregunta 'ver productos', responde: Puedes ver los productos registrados en el menú 'Productos'." },
    { role: "system", content: "Si alguien pregunta 'crear producto', responde: Haz clic en 'Productos' y luego en 'Crear Producto'." },
    { role: "system", content: "Puedes ayudar con usuarios, productos, roles y permisos." }
  ];

  const AZURE_OPENAI_ENDPOINT = 'https://danie-mbo0n7z7-eastus2.cognitiveservices.azure.com/';
  const DEPLOYMENT_ID = 'gpt-4';
  const API_VERSION = '2024-12-01-preview';
  const API_KEY = '7uWuOtqL9Sj2uDVC7TY2E6ZpGm2nPQ0ToB0z4gFUDIpzqd1KGaBRJQQJ99BFACHYHv6XJ3w3AAAAACOGZRrI';
 document.getElementById('chatInput').addEventListener('keypress', async function (e) {
    if (e.key === 'Enter') {
      const inputText = e.target.value.trim().toLowerCase();
      if (!inputText) return;

      appendMessage('Tú', inputText);
      e.target.value = '';

      if (respuestasLocales[inputText]) {
        appendMessage('Bot', respuestasLocales[inputText]);
        return;
      }

      const messages = [
        ...contextoBase,
        { role: "user", content: inputText }
      ];

      try {
        const response = await fetch(`${AZURE_OPENAI_ENDPOINT}openai/deployments/${DEPLOYMENT_ID}/chat/completions?api-version=${API_VERSION}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "api-key": API_KEY
          },
          body: JSON.stringify({
            messages: messages,
            max_tokens: 100
          })
        });

        const data = await response.json();
        const respuestaIA = data?.choices?.[0]?.message?.content?.trim();
        appendMessage('Bot', respuestaIA || '⚠️ Sin respuesta válida.');

      } catch (error) {
        console.error("Error:", error);
        appendMessage('Bot', '⚠️ Error al conectarse con Azure.');
      }
    }
  });

  function appendMessage(sender, text) {
    const content = document.getElementById('chatbotContent');
    const p = document.createElement('p');
    p.innerHTML = `<strong>${sender}:</strong> ${text}`;
    content.appendChild(p);
    content.scrollTop = content.scrollHeight;
  }
</script>




<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1482.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>




@stop
