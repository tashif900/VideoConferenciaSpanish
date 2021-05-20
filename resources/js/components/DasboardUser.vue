<template>
        <div class="col-12">
            <nav class="profile-tabs">
                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                    <router-link class="nav-link" v-bind:class="{ active: ishome }" id="nav-home-tab" data-toggle="tab" to="/dashboard-user" role="tab" aria-controls="nav-home" aria-selected="true"><img src="/img/home.png"> <span>Home</span></router-link>
                    <router-link class="nav-link" v-bind:class="{ active: isprofile }" id="nav-profile-tab" data-toggle="tab" to="/dashboard-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><img src="/img/perfil.png"> <span>Perfil</span></router-link>
                    <router-link class="nav-link" v-bind:class="{ active: ispayment }" id="nav-payment-tab" data-toggle="tab" to="/dashboard-payment" role="tab" aria-controls="nav-payment" aria-selected="false"><img src="/img/metodo-pago.png"> <span>Métodos de Pago</span></router-link>
                    <router-link class="nav-link" v-bind:class="{ active: ishelp_desk }"  id="nav-help-tab" data-toggle="tab" to="/dashboard-help" role="tab" aria-controls="nav-help" aria-selected="false"><img src="/img/centro-ayuda.png"> <span>Centro de Ayuda</span></router-link>
                    <router-link class="nav-link" v-bind:class="{ active: isincome }"  id="nav-income-tab" data-toggle="tab" to="/dashboard-income" role="tab" aria-controls="nav-income" aria-selected="false"><img src="/img/tus-ingresos.png"> <span>Tus Ingresos</span></router-link>
                    <router-link class="nav-link"  v-bind:class="{ active: isschedule }" id="nav-agenda-tab" data-toggle="tab" to="/dashboard-schedule" role="tab" aria-controls="nav-agenda" aria-selected="false"><img src="/img/agenda.png"> <span>Agenda</span></router-link>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade" v-bind:class="{ 'show active': ishome }" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form action="">
                        <div class="row">
                            <div class="col-12 col-md-6 mt-4 justify-content-center">
                                <h2 class="title-red">entrar en una reunión</h2>
                                <div class="form-group mt-4">
                                    <input type="text" class="form-control-custom-purple mx-auto" placeholder="id de reunión">
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-custom-red">ENTRAR</button>
                                </div>

                            </div>
                            <div class="col-12 col-md-6 mt-4 justify-content-center home">
                                <h2 class="title-red">ANFITRIÓN</h2>
                                <div class="form-group mt-4">
                                    <router-link to="meetingtype">
                                        <button class="btn btn-custom-purple mx-auto">CREAR UNA reunión</button>
                                    </router-link>
                                </div>
                                <div class="form-group mt-4">
                                    <router-link to="findmeeting">
                                        <button class="btn btn-custom-purple mx-auto">tengo agendado una cita</button>
                                    </router-link>

                                </div>
                                <div class="form-group mt-4">
                                    <router-link to="/add-course">
                                        <button class="btn btn-custom-purple mx-auto">crear un curso</button>
                                    </router-link>

                                </div>
                                <div class="form-group mt-4">
                                    <router-link to="/add-class">
                                        <button class="btn btn-custom-purple mx-auto">CREAR UNA clase</button>
                                    </router-link>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" v-bind:class="{ 'show active': isprofile }" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row mt-4">
                        <div class="col-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab2" role="tablist">
                                    <a class="nav-link active" id="nav-home-tab2" data-toggle="tab" href="#nav-home2" role="tab" aria-controls="nav-home2" aria-selected="true">Datos Personales</a>
                                    <a v-if="isInstructor" class="nav-link" id="nav-profile-tab2" data-toggle="tab" href="#nav-profile2" role="tab" aria-controls="nav-profile2" aria-selected="false">Instructor</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent2">
                                <div class="tab-pane fade show active" id="nav-home2" role="tabpanel" aria-labelledby="nav-home2-tab">
                                        <div class="row my-4">
                                            <div class="col-12 col-md-3 text-center">
                                                <img :src="get_avatar()" width="150px" height="150px" class="rounded-circle" alt="">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="filename" class="custom-file-input" id="inputFileUpload"
                                                            v-on:change="onFileChange">
                                                        <label class="custom-file-label" for="inputFileUpload">Choose file</label>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-block btn-dark mt-3" @click="submitForm">Subir Foto</button>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Nombres</label>
                                                            <div class="col-sm-8">
                                                                <input v-model="User.name" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Fecha Nac.</label>
                                                            <div class="col-sm-8">
                                                                <input v-model="User.people.birth_date" type="date" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Nacionalidad</label>
                                                            <div class="col-sm-8">
                                                                <select v-model="User.people.country_id" class="form-control">
                                                                    <option value="0">Ninguna</option>
                                                                    <option v-for="c in Country" :value="c.id">{{c.name}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Profesión</label>
                                                            <div class="col-sm-8">
                                                                <input v-model="User.people.profession" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Teléfono</label>
                                                            <div class="col-sm-8">
                                                                <input v-model="User.people.phone" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group row mt-3">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Grado</label>
                                                            <div class="col-sm-8">
                                                                <input v-model="User.people.grade" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Intereses</label>
                                                    <multiselect v-model="interests" :options="interesetsOptions" :multiple="true" :taggable="true" label="name" track-by="code" @tag="addTag"  :searchable="false" :close-on-select="false" :show-labels="false" placeholder="Seleccione sus intereses"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Descripción</label>
                                                    <textarea v-model="User.people.description" type="text" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h5>Datos de la Cuenta</h5>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Correo Electrónico</label>
                                                    <input v-model="User.email" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">Contraseña</label>
                                                    <input v-model="User.password" type="password" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-12">
                                                <button class="btn btn-rounded btn-custom-red"  @click="savePersonData">Guardar</button>
                                                <button class="btn btn-rounded btn-custom-blue">Cancelar</button>
                                            </div>
                                        </div>
                                </div>
                                <div v-if="isInstructor" class="tab-pane fade" id="nav-profile2" role="tabpanel" aria-labelledby="nav-profile2-tab">
                                        <div class="row my-4">
                                            <div class="col-12">
                                                <h4>Datos Generales</h4>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Tipo Documento</label>
                                                    <div class="col-sm-8">
                                                        <select v-model="User.people.document_type_id" class="form-control">
                                                            <option value="0">Ninguna</option>
                                                            <option v-for="c in TypeDocuments" :value="c.id">{{c.description}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Nro. Documento</label>
                                                    <div class="col-sm-8">
                                                        <input v-model="User.people.document_number" type="text" class="form-control" id="staticEmail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Grado de Instrucción</label>
                                                    <div class="col-sm-8">
                                                        <input v-model="User.people.grade_instruction" type="text" class="form-control" id="staticGrade">
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Tipo de Institución</label>
                                                    <div class="col-sm-8">
                                                        <select v-model="User.people.institution_type_id" class="form-control">
                                                            <option value="0">Ninguna</option>
                                                            <option v-for="c in InstitutionTypes" :value="c.id">{{c.description}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Nombre de Institución</label>
                                                    <div class="col-sm-8">
                                                        <input v-model="User.people.name_institution" type="text" class="form-control" id="staticNameInstitution">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Otros Datos</h4>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Categoría</label>
                                                    <div class="col-sm-8">
                                                        <select v-model="User.thematic_id" class="form-control">
                                                            <option v-for="item in Category" :value="item.id">
                                                                {{item.name}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group row mt-3">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Última Conexión</label>
                                                    <div class="col-sm-8">
                                                        <input v-model="User.last_session" type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-12">
                                                <button class="btn btn-rounded btn-custom-red" @click="saveInstructor">Guardar</button>
                                                <button class="btn btn-rounded btn-custom-blue">Cancelar</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" v-bind:class="{ 'show active': ispayment }"  id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                        <div class="row my-4">
                            <div class="col-12 col-md-6">
                                <h2 class="title-blue mb-4">Tus métodos de pago</h2>
                                <div class="card-white-item payments-user">
                                    <div class="payments-user-img">
                                        <img src="/img/visa.jpg" alt="">
                                    </div>
                                    1234**********1456
                                </div>
                                <div class="card-white-item payments-user">
                                    <div class="payments-user-img">
                                        <img src="/img/mastercard.png" alt="">
                                    </div>
                                    1234**********1456
                                </div>
                                <div class="card-white-item payments-user">
                                    <div class="payments-user-img">
                                        <img src="/img/american.png" alt="">
                                    </div>
                                    1234**********1456
                                </div>
                                <div class="card-white-item payments-user">
                                    <div class="payments-user-img">
                                        <img src="/img/paypal.png" alt="">
                                    </div>
                                    example@example.com
                                </div>
                            </div>
                            <div  v-if="isInstructor" class="col-12 col-md-6">
                                <h2 class="title-blue mb-4">Tu cuenta para que te paguemos</h2>
                                <div class="payment-input-cont">
                                    <label for="bank" class="payment-input-label">Banco</label>
                                    <input  type="text" class="payment-input-control" id="bank">
                                </div>
                                <div class="payment-input-cont">
                                    <label for="clabe" class="payment-input-label">Clabe</label>
                                    <input  type="text" class="payment-input-control" id="clabe">
                                </div>
                                <div class="payment-input-cont">
                                    <label for="account" class="payment-input-label">N° de Cuenta</label>
                                    <input type="text" class="payment-input-control" id="account">
                                </div>
                                <div class="payment-input-cont">
                                    <label for="name" class="payment-input-label">Nombre Titular</label>
                                    <input  type="text" class="payment-input-control" id="name">
                                </div>
                                <div class="payment-input-cont">
                                    <label for="lastname" class="payment-input-label">Apellido Titular</label>
                                    <input type="text" class="payment-input-control" id="lastname">
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-custom-red" @click="savePaymentAccount">Guardar</button>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="tab-pane fade" v-bind:class="{ 'show active': ishelp_desk }"  id="nav-help" role="tabpanel" aria-labelledby="nav-help-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="button" class="btn btn-custom-blue" data-toggle="modal" data-target="#newRequest">
                                    Nueva Consulta
                                </button>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-custom-blue">Historial</button>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Título</th>
                                            <th scope="col">Mensaje</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">*</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in Help_desks">
                                            <td>{{item.created_at | moment }}</td>
                                            <td>{{item.title}}</td>
                                            <td>{{item.description}}</td>
                                            <td>{{ getStateHelpDesk(item.state)}}</td>
                                            <td><button @click="viewHelpDesk(item)" class="btn btn-custom-blue">Ver</button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="tab-pane fade" v-bind:class="{ 'show active': isincome }" id="nav-income" role="tabpanel" aria-labelledby="nav-income-tab">
                    <form action="">
                        <div class="row mt-4">
                            <div class="col-12 col-md-3">
                                <div class="card card-colors">
                                    <div class="card-header">
                                        Periodo
                                    </div>
                                    <div class="card-body">
                                        <select name="periodo" id="periodo" class="form-control">
                                            <option value="">Agosto 2020</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card card-colors mt-3">
                                    <div class="card-header">
                                        Último Retiro
                                    </div>
                                    <div class="card-body text-center">
                                        <p>$ 220.00</p>
                                        <button class="btn btn-custom-blue" type="button" data-toggle="none" id="requestOutcome">Solicitar Retiro</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Retiros</h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th align="center">Fecha</th>
                                                    <th align="center">Periodo</th>
                                                    <th align="center">Monto</th>
                                                    <th align="center">Estado</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <td colspan="2" align="right"><strong>Total</strong></td>
                                                    <td align="right">$ 220.00</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h4>Actividad</h4>
                            </div>
                            <div class="col-12">
                                <table class="table" id="activityTable">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">Periodo</th>
                                        <th class="text-center">Curso</th>
                                        <th class="text-center">Participantes</th>
                                        <th class="text-center">Monto</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" v-bind:class="{ 'show active': isschedule }"  id="nav-agenda" role="tabpanel" aria-labelledby="nav-agenda-tab">
                    <div class="row my-4">
                        <div class="col-12 d-flex justify-content-center">
                            <router-link to="/schedulemeeting">
                                <button class="btn btn-custom-blue btn-rounded">Crear una reunión</button>
                            </router-link>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="row schedule-table-content">
                                <div class="col-12">
                                    <h4 class="mydateTitle green"><strong>Mis Citas</strong> <span></span></h4>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-green">
                                            <tr>
                                                <th scope="col">Cita</th>
                                                <th scope="col">Hora</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr  v-for="meeting in todayMeeting" :key="meeting">
                                                <td>{{ meeting.name }}</td>
                                                <td>{{ meeting.hour }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row schedule-table-content">
                                <div class="col-12">
                                    <h4 class="mydateTitle blue"><strong>Próximas Citas</strong> <span></span></h4>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-blue">
                                            <tr>
                                                <th scope="col">Cita</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Hora</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr  v-for="meeting2 in upcomingMeeting" :key="meeting2.name">
                                                <td>{{ meeting2.name }}</td>
                                                <td>{{ meeting2.date }}</td>
                                                <td>{{ meeting2.hour }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row schedule-table-content">
                                <div class="col-12">
                                    <h4 class="mydateTitle pink"><strong>Citas Pasadas</strong> <span></span></h4>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-pink">
                                            <tr>
                                                <th scope="col">Nombres y Apellidos</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Hora</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr  v-for="meeting3 in pastMeeting">
                                                <td>{{ meeting3.name }}</td>
                                                <td>{{ meeting3.date }}</td>
                                                <td>{{ meeting3.hour }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <functional-calendar :marked-dates='markedDates'></functional-calendar>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-outcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Solicitar Retiro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label >Periodo</label>
                                        <select name="period" id="period" class="form-control" style="width: 300px">
                                            <option value="">Agosto 2020</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Factura 1</label>
                                        <div class="cumtom-input-file-wrapper">
                                        <span class="label">
                                            <i class="ti-plus"></i>
                                        </span>

                                            <input type="file" name="upload" id="upload" class="cumtom-input-file-upload-box" placeholder="Upload File">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Factura 2</label>
                                        <div class="cumtom-input-file-wrapper">
                                    <span class="label">
                                        <i class="ti-plus"></i>
                                    </span>

                                            <input type="file" name="upload" id="upload" class="cumtom-input-file-upload-box" placeholder="Upload File">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-custom-red mb-2" id="addPeriod">Agregar</button>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-rounded btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-rounded btn-custom-blue">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="newRequest" tabindex="-1" aria-labelledby="newRequestLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newRequestLabel">Nueva Consulta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 mt-3">
                                <input v-model="Helpdesk.title" class="form-control" placeholder="Escribe el título de tu consulta">
                            </div>
                            <div class="col-12 mt-3">
                                <textarea v-model="Helpdesk.description" name="" id="" cols="30" rows="10" class="form-control" placeholder="Escribe aquí tu duda y pronto se pondrán en contacto contigo"></textarea>
                            </div>
                            <div class="col-12 mt-4">
                            <h4>Respuestas</h4>
                            <div v-if="Help_desks_response.length>0" >
                                <div v-for="item in Help_desks_response">
                                    <div class="col-12 mt-3">
                                        <input v-model="item.title" class="form-control" readonly>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <textarea v-model="item.description" name="" id="" cols="30" rows="10" class="form-control" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <span>Sin respuestas</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-custom-red" @click="saveHelpDesk">Enviar</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import { FunctionalCalendar } from 'vue-functional-calendar';
    import Multiselect from 'vue-multiselect'
    import moment from 'moment';

    export default {
        props:[
            //Carga propiedades externas
            'home', 'profile', 'payment', 'help_desk', 'income', 'schedule'
        ],
        components: {
            FunctionalCalendar, 'multiselect': Multiselect
        },
        mounted() {
            //Lista Paises
            this.getCountry ();
            this.getTypeDocuments();
            this.getInstitutionTypes();
            this.getUser();
            this.getTodaysMeeting();
            this.getUpcomingMeeting();
            this.getPastsMeeting();
            this.getHelpDeksUser();
            this.getInterests();
            this.get_avatar();

            this.avatar = this.$store.state.user.photo;
            //Muestra Modal con Jquery
            $('#requestOutcome').click(function() {
                $('#modal-outcome').modal('show');
            })
        },
        data(){
            return {
                ishome : this.home,
                isprofile : this.profile,
                ispayment : this.payment,
                ishelp_desk: this.help_desk,
                isincome: this.income,
                isschedule: this.schedule,

                filename: '',
                file: '',
                success: '',

                avatar: null,

                Country:[],
                TypeDocuments:[],
                InstitutionTypes: [],
                User: {
                    people:{
                        paypal:"",
                        clabe:""
                    },
                    roles:[],
                    payment_method_users:[],
                    payment_account: []
                },
                Payment_account: {},
                Helpdesk: {},
                Help_desks: [],
                Help_desks_response: [],

                todayMeeting: [],
                upcomingMeeting: [],
                pastMeeting: [],

                calendarData: {},
                calendarConfigs: {
                    sundayStart: false,
                    dateFormat: 'dd-mm-yyyy',
                    isDatePicker: false,
                    isDateRange: false
                },
                markedDates: [],

                interesetsOptions: [],
                interests: [],
                checkPlan_d:false
            }
        },
        methods:{
            getCountry (){
                let url ="/api/getCountries"
                axios.get(url).then(response =>{
                    this.Country = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getInterests: function() {
                let url ="/api/get-interests"
                axios.get(url).then(response =>{
                    /*let interesess = [];
                    for (let index = 0; index < response.data.length; index++) {
                        interesess.push({
                            name: response.data[index]['name'],
                            code: response.data[index]['id'],
                        });
                    }*/
                    //console.log(response.data, 'Intereses');
                    this.interesetsOptions = response.data;
                    //console.log(this.interesetsOptions, 'Intereses');
                }).catch(error => {
                    console.log(error);
                })
            },
            getTypeDocuments(){
                let url ="/api/getTypeDocuments"
                axios.get(url).then(response =>{
                    this.TypeDocuments = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },

            getInstitutionTypes(){
                let url ="/api/getInstitutionTypes"
                axios.get(url).then(response =>{
                    this.InstitutionTypes = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getHelpDeksUser (){
                let url ="/api/getHelpDeksUser";

                axios.get(url,  {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    this.Help_desks =response.data;
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },
            getUser(){
                //Carga Usuario Logueado
                this.User = this.$store.state.user;
                this.User.people.country_id == null ? this.User.people.country_id=0 : "";
                this.User.people.document_type_id == null ? this.User.people.document_type_id=0 : "";
                this.User.people.institution_type_id == null ? this.User.people.institution_type_id=0 : "";
                this.Payment_account = this.User.payment_account;
                this.getMethodUser();
            },

            //Obtener Paypal y CLABE
            getMethodUser (){
                let paypal = "";
                let clabe ="";
                this.User.payment_method_users.forEach(function (method) {
                    if (method.payment_method_id ==1){
                        paypal = method.value;
                    }else if (method.payment_method_id ==2){
                        clabe = method.value;
                    }
                });
                this.User.people.paypal =paypal;
                this.User.people.clabe =clabe;
            },

            setMethodUser (){
                let paypal = this.User.people.paypal;
                let clabe =this.User.people.clabe;
                this.User.payment_method_users.forEach(function (method) {
                    if (method.payment_method_id ==1){
                        method.value = paypal != "" ? paypal : "-";
                    }else if (method.payment_method_id ==2){
                        method.value = clabe != "" ? clabe: "-";
                    }
                });
            },
            savePersonData (){
                let url ="/api/updatePersonalData"
                axios.post(url, this.User , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    let user = response.data;
                    localStorage.setItem('user_login',JSON.stringify(user))
                    this.$store.commit('getUser', user)
                    toastr.success('Se ha grabado correctamente');
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },

            saveInstructor(){
                this.setMethodUser();
                let url ="/api/updateInstructor";
                axios.post(url, this.User , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    let user = response.data;
                    localStorage.setItem('user_login',JSON.stringify(user))
                    this.$store.commit('getUser', user)
                    toastr.success('Se ha grabado correctamente');
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },

            savePaymentAccount(){
                let url ="/api/updatePaymentAccount";
                axios.post(url, this.Payment_account , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    //console.log(response.data, 'Respuesta');
                    this.Payment_account = response.data;
                    this.User.Payment_account = this.Payment_account;

                    localStorage.setItem('user_login',JSON.stringify(this.User))
                    this.$store.commit('getUser', this.User)
                    toastr.success('Se ha grabado correctamente');
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },
            getTodaysMeeting() {
                let url = '/api/get-todays-meeting';
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.todayMeeting = response.data;

                    let todatMeetings = [];
                    for (let index = 0; index < response.data.length; index++) {
                        let date = response.data[index]['date'];
                        let fecha = date.split('-');
                        this.markedDates.push({
                            // date: fecha[1] + '/' + fecha[0] + '/' + fecha[2],
                            date: response.data[index]['datej'],
                            class: 'todayMeetings',
                        });
                    }
                    // .push(todatMeetings)
                    console.log(this.markedDates, 'hoooooooooooy')
                }).catch(error => {
                    //toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },
            saveHelpDesk(){
                let url ="/api/saveHelpDesk";

                axios.post(url, this.Helpdesk , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    if (response.data==true) {
                        this.getHelpDeksUser();
                        toastr.success('Se ha grabado correctamente');
                        $('#newRequest').modal('hide');

                        this.Helpdesk.description = '';
                        this.Helpdesk.title = '';
                    } else{
                        toastr.error('Ha ocurrido un error inesperado :(');
                    }
                }).catch(error => {
                    toastr.error('Ha ocurrido un error inesperado :(');
                })
            },
            getStateHelpDesk(state){
                if(state==1)
                
                    return 'Pendiente';
                else if (state==2)
                    return 'Respondido'
                else
                    return 'Cerrado';

            },

            viewHelpDesk(item){
                let url ="/api/editHelpDesk";
                axios.get(url, {
                    headers:{Authorization: "Bearer " + this.$store.state.token},
                    params:item
                }).then(response =>{
                    this.Helpdesk = response.data;
                    this.Help_desks_response = response.data.helpdesks;
                    $('#newRequest').modal('show');
                    console.log(this.Help_desks_response, 'Response Desk');
                }).catch(error => {
                    console.log(error, 'error view help');
                })
            },

            getUpcomingMeeting() {
                let url = '/api/get-upcoming-meeting';
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.upcomingMeeting = response.data;

                    let upcomingMeetings = [];
                    for (let index = 0; index < response.data.length; index++) {
                        let date = response.data[index]['date'];
                        let fecha = date.split('-');
                        this.markedDates.push({
                            // date: fecha[0] + '/' + fecha[1] + '/' + fecha[2],
                            date: response.data[index]['datej'],
                            class: 'upcomingMeetings',
                        });
                    }
                    // this.markedDates.push(upcomingMeetings) 
                    console.log(this.markedDates, 'upppppppppppcomming')
                }).catch(error => {
                    //toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },
            getPastsMeeting() {
                let url = '/api/get-pasts-meeting';
                axios.post(url, {user: this.$store.state.user.id} , {
                    headers:{Authorization: "Bearer " + this.$store.state.token}
                }).then(response =>{
                    this.pastMeeting = response.data;

                    let pastMeetings = [];
                    for (let index = 0; index < response.data.length; index++) {
                        let date = response.data[index]['datej'];
                        let fecha = date.split('-');
                        this.markedDates.push({
                            // date: fecha[0] + '/' + fecha[1] + '/' + fecha[2],
                            date: response.data[index]['date'],
                            class: 'pastMeetings',
                        });
                    }
                    // this.markedDates.push(pastMeetings)
                    console.log(this.markedDates, 'pastsssssssssssssssssssssssssss')

                    // console.log(this.pastMeeting, 'past');
                }).catch(error => {
                   // toastr.error('Ha ocurrido un error inesperado :(');
                    console.log(error);
                })
            },
            addTag(newTag) {
                console.log(newTag);
                // const tag = {
                //     name: newTag,
                //     code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                // }
                // this.interesetsOptions.push(tag)
                // this.interests.push(tag)
            },
            onFileChange(e) {
                this.filename = "Archivo Seleccionado: " + e.target.files[0].name;
                this.file = e.target.files[0];
            },
            submitForm(e) {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }

                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('/api/upload-avatar?user=' + this.$store.state.user.id, formData, config)
                .then(function (response) {
                    if (response.data.response == true) {
                        toastr.success('Se actualizó correctamente tu foto de perfil');
                        this.$store.state.user.photo = response.data.path;

                        this.get_avatar();
                    } else {
                        toastr.error('Ha ocurrido un error inesperado :(');
                    }
                })
                .catch(function (error) {
                    toastr.error('Ha ocurrido un error inesperado :(');
                });
            },
            get_avatar() {
                return this.$store.state.user.photo
            },



        },
        computed:{
            isInstructor (){
                return this.$store.state.user.roles[0].name == "Profesor";
            },
            Category(){
                return this.$store.getters.getCategories;
            }
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD/MM/YYYY , h:mm:ss a');
            }
        },
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
    .home a:link, a:visited, a:active {
        text-decoration:none;
    }

    .vfc-today {
        background-color: #83E8CD !important;
    }

    .todayMeetings {
        background: red !important;
    }

    .pastMeetings {
        background: green;
    }
</style>