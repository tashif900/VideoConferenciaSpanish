@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Perfil de Usuario</h2>
        </div>

        <div class="card-body">
        <form method="post" id="formProfile" name="formProfile">
        <input type="text" name="id" value="{{ $user->id }}" hidden>
                @csrf 
                <input type="hidden" id="user_id" name="user_id">
                <div class="row col-md-12" id="marcoUsuario">
                  <div class="col-md-6 cardform">
                    <div class="card">
                      <div class="card-body">
                          <div class="form-group">
                              <label for="description">Nombre *</label>
                              <input type="text" class="form-control" id="name" name="name"
                                      placeholder="Ingresar tu nombre" value="{{$user->name}}" required >
                          </div>
                          <div class="form-group">
                              <label for="description">Email *</label>
                              <input type="text" class="form-control" id="email" name="email"
                                      placeholder="Ingresar tu email" value="{{$user->email}}" required readonly>
                          </div>
                          <div class="form-group">
                              <label for="description">Social Network</label>
                              <input type="text" class="form-control" id="social_network" name="social_network"
                                      placeholder="Ingresar tu nombre" value="{{$user->social_network}}" required >
                          </div>
                          <div class="form-group">
                              <label for="description">Pregunta de seguridad</label>
                              <input type="text" class="form-control" id="security_question" name="security_question"
                                      placeholder="Ingresar tu nombre" value="{{$user->security_question}}" required >
                          </div>
                          <div class="form-group">
                              <label for="description">Respuesta de seguridad</label>
                              <input type="text" class="form-control" id="security_answer" name="security_answer"
                                      placeholder="Ingresar tu nombre" value="{{$user->security_answer}}" required >
                          </div>
                          <div class="form-group">
                              <label for="country">Pais</label>
                              <select class="form-control" name="country_id" id="country_id">
                                  @foreach($countries as $c)
                                      <option value="{{$c->id}}"
                                              @if($user->people->country_id === $c->id)
                                                  selected
                                              @endif>
                                              {{$c->name}}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="country">Tipo de institución</label>
                            <select class="form-control" name="institution_type_id" id="institution_type_id">
                                @foreach($institution_types as $t)
                                    <option value="{{$t->id}}"
                                            @if($user->people->institution_type_id === $t->id)
                                                selected
                                            @endif>
                                            {{$t->description}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="country">Tipo de documento</label>
                            <select class="form-control" name="document_type_id" id="document_type_id">
                                @foreach($document_type as $d)
                                    <option value="{{$t->id}}"
                                            @if($user->people->document_type_id === $d->id)
                                                selected
                                            @endif>
                                            {{$d->description}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="description">Contraseña nueva</label>
                            <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Ingresar tu nombre">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 cardform">
                      <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="description">Fecha de cumpleaños</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date"
                                        placeholder="Ingresar tu nombre" value="{{$user->people->birth_date}}" required >
                            </div>
                            <div class="form-group">
                                <label for="description">Telefono</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                        placeholder="Ingresar tu email" value="{{$user->people->phone}}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Grado</label>
                                <input type="text" class="form-control" id="grade" name="grade"
                                        placeholder="Ingresar tu nombre" value="{{$user->people->grade}}" required >
                            </div>
                            <div class="form-group">
                                <label for="description">Profesion</label>
                                <input type="text" class="form-control" id="profession" name="profession"
                                        placeholder="Ingresar tu nombre" value="{{$user->people->profession}}" required >
                            </div>
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <input type="text" class="form-control" id="description" name="description"
                                        placeholder="Ingresar tu nombre" value="{{$user->people->description}}" required >
                            </div>
                            <div class="form-group">
                              <label for="description">Grado de la institución</label>
                              <input type="text" class="form-control" id="grade_instruction" name="grade_instruction"
                                      placeholder="Ingresar tu nombre" value="{{$user->people->grade_instruction}}" required >
                            </div>
                            <div class="form-group">
                                <label for="description">Profesion</label>
                                <input type="text" class="form-control" id="name_institution" name="name_institution"
                                        placeholder="Ingresar tu nombre" value="{{$user->people->name_institution}}" required >
                            </div>
                            <div class="form-group">
                                <label for="description">Descripcion</label>
                                <input type="text" class="form-control" id="document_number" name="document_number"
                                        placeholder="Ingresar tu nombre" value="{{$user->people->document_number}}" required >
                            </div>
                          </div>
                        </div>
                      </div>
                  
                  </div>  
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-warning" id="btnSave">Grabar</button>
        </div>
        @stop

@section('css')

@stop

@section('js')
  <script>  
    $('#btnSave').click(function () {
      let data = $('#formProfile').serialize();
      if($('#name').val() == '')
      {
        toastr("El campo nombre es obligatorio");
        return false;
      }
      $.ajax({
          url: "{{ route('saveuser') }}",
          type: 'post',
          data: data,
          'success': function (response) {
            $('#password').val('');
            if (response != false) 
              toastr.success('Se grabó satisfactoramente');
            else
              toastr.error('Ha ocurrido un error :(');
          }
        });   
      });
  </script>
@stop
