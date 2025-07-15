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

const AZURE_OPENAI_ENDPOINT ='https://mille-md44djyf-swedencentral.cognitiveservices.azure.com/';
const DEPLOYMENT_ID = 'gpt-4'; // Asegúrate de que este Deployment ID sea el correcto
const API_VERSION = '2024-12-01-preview';
const API_KEY = 'EiXUa7B9ywiK9fIVwAazMT4UaernZIT3ibhIUbkTEeb06ffYUix0JQQJ99BGACfhMk5XJ3w3AAAAACOG7Vtz'; // Asegúrate de que esta sea la clave correcta

const contextoBase = [
    { role: "system", content: "Eres un asistente útil para navegar por un sistema de ventas y gestión de inventarios." },
    { role: "system", content: "Si alguien pregunta '¿Dónde está el Dashboard?', responde: 'Para acceder al Dashboard, ve a la sección 'Inicio' en el menú principal. El Dashboard muestra estadísticas clave sobre las ventas, usuarios activos y rendimiento general.'" },
    { role: "system", content: "Si alguien pregunta '¿Cómo gestiono los usuarios?', responde: 'Para gestionar usuarios, ve al menú 'Usuarios' y haz clic en 'Gestionar Usuarios'. Desde ahí, puedes agregar, editar o eliminar usuarios, y asignarles roles.'" },
    { role: "system", content: "Si alguien pregunta '¿Cómo veo los productos?', responde: 'Ve a 'Productos' y selecciona 'Listado de productos'. Ahí podrás ver todos los productos registrados.'"},
    { role: "system", content: "Si alguien pregunta '¿Cómo gestiono los roles?', responde: 'Para gestionar roles y permisos, ve a 'Roles' en el menú. Ahí podrás asignar roles a los usuarios y configurar sus permisos según sus funciones.'" },
    { role: "system", content: "Si alguien pregunta '¿Dónde veo las facturas?', responde: 'Para acceder a la facturación, dirígete a 'Facturación' en el menú. Aquí podrás ver las facturas generadas y realizar consultas sobre pagos.'" },
    { role: "system", content: "Si alguien pregunta '¿Cómo generar un reporte?', responde: 'Para generar reportes, ve a la sección 'Reportes' en el menú. Puedes ver informes sobre ventas, productos más vendidos, y otros datos relevantes del sistema.'" },
    { role: "system", content: "Si alguien pregunta '¿Cómo puedo obtener ayuda?', responde: 'Si necesitas soporte, puedes ir a la sección 'Ayuda' en el menú o escribir aquí lo que necesitas y estaré encantado de guiarte.'" },
    { role: "system", content: "Puedes ayudar con tareas como la gestión de usuarios, productos, roles, facturación y reportes en el sistema." }
];

document.getElementById('chatInput').addEventListener('keypress', async function (e) {
    if (e.key === 'Enter') {
        const inputText = e.target.value.trim().toLowerCase();
        if (!inputText) return;

        appendMessage('Tú', inputText);
        e.target.value = '';

        // Crear los mensajes que se enviarán a la IA (incluyendo el contexto)
        const messages = [
            ...contextoBase,
            { role: "user", content: inputText }
        ];

        try {
            // Enviar la solicitud a Azure OpenAI con el contexto completo
            const response = await fetch(`${AZURE_OPENAI_ENDPOINT}openai/deployments/${DEPLOYMENT_ID}/chat/completions?api-version=${API_VERSION}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "api-key": API_KEY
                },
                body: JSON.stringify({
                    messages: messages,
                    max_tokens: 150
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
