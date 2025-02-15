@extends('common.emails.layout')
@section('content')

      @foreach($data['request'] as $k=>$value)
          <?php
          if($k == "order_id"){
              $k = "Ordine n.";
          }

          if($k == "name_support"){
              $k = "Oggetto";
          }

          if($k == "content_support"){
              $k = "Messaggio";
          }
          $label = ucfirst(str_replace("_", " ", $k));
          ?>
          @if(is_array($value))
              <p><strong>{{ $label }}:</strong></p>
              <ul>
              @foreach($value as $v)
                <li>{{ $v }}</li>
              @endforeach
              </ul>
          @else

              @if(!in_array($label, ['G-recaptcha-response', 'Valid from', 'My name']))
                  @if($value == "1")
                      <p><strong>{{ $label }}:</strong> SI</p>
                  @else
                      <p><strong>{{ $label }}:</strong> {{ $value }}</p>
                  @endif
              @endif
          @endif
      @endforeach
@endsection
