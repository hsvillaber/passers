<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Examinee Passers</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col col-lg-6">
                <h3>Examinee Information:</h3>
                <div id="addstudent">

                    <form v-on:submit="sub" action="/addstudent" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col col-xs-6">
                                    <input v-model="firstname" placeholder="First Name" class="form-control" name="firstname">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                                <div class="col col-xs-6">
                                    <input v-model="lastname" placeholder="Last Name" class="form-control" name="lastname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input v-model="campus" placeholder="Campus Eligibility" class="form-control" name="campus">
                        </div>
                        <div class="form-group">
                            <input v-model="school" placeholder="School" class="form-control" name="school">
                        </div>
                        <div class="form-group">
                            <input v-model="division" placeholder="Division" class="form-control" name="division">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>


                    </form>

                </div>
            </div>

            <div class="col col-lg-6">
                <projects></projects>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
</html>
