@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if($errors->any())
          <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
              </ul>
          </div>
        @endif
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Báo cáo</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <form action="/report/show" method="GET">
        <div class="col-md-12">
        <label>Chọn Ngày</label>
             <div class="col-sm-6">
          <label for="date-startInput" class="form-label">From</label>
          <div
            class="input-group log-event"
            id="date-start"
            data-td-target-input="nearest"
            data-td-target-toggle="nearest"
          >
            <input
              id="date-startInput"
              type="text"
              class="form-control"
              data-td-target="#date-start"
            />
            <span
              class="input-group-text"
              data-td-target="#date-start"
              data-td-toggle="datetimepicker"
            >
              <span class="fa-solid fa-calendar"></span>
            </span>
          </div>
        </div>
        <div class="col-sm-6">
          <label for="date-endInput" class="form-label">To</label>
          <div
            class="input-group log-event"
            id="date-end"
            data-td-target-input="nearest"
            data-td-target-toggle="nearest"
          >
            <input
              id="date-endInput"
              type="text"
              class="form-control"
              data-td-target="#date-end"
            />
            <span
              class="input-group-text"
              data-td-target="#date-end"
              data-td-toggle="datetimepicker"
            >
              <span class="fa-solid fa-calendar"></span>
            </span>
          </div>
        </div>
          <input class="btn btn-primary" type="submit" value="Hiển thị báo cáo">
        
        </div>
      </form>
    </div>
  </div>

  <script type="module">
      import { TempusDominus, Namespace } from '@eonasdan/tempus-dominus';
      const linkedPicker1Element = document.getElementById('date-start');
      const linked1 = new TempusDominus(linkedPicker1Element);
      const linked2 = new TempusDominus(document.getElementById('date-end'), {
        useCurrent: false,
      });

      //using event listeners
      linkedPicker1Element.addEventListener(Namespace.events.change, (e) => {
        linked2.updateOptions({
          restrictions: {
            minDate: e.detail.date,
          },
        });
      });

      //using subscribe method
      const subscription = linked2.subscribe(Namespace.events.change, (e) => {
        linked1.updateOptions({
          restrictions: {
            maxDate: e.date,
          },
        });
      });
  </script>


@endsection