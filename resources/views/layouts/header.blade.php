  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" >
    <div class="container">
      <a class="navbar-brand" href="{{url('/')}}" style="color:#1e84e4">Writing room</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto" >
          <li class="nav-item" >
            <a class="nav-link" href="{{url('editor/main/graph')}}" style="color:#45b4e6">Revenue graph</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" style="color:#45b4e6">Chatting</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('auth/login_editor')}}" style="color:#45b4e6">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>