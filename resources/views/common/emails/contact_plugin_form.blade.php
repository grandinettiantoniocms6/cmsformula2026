@extends('common.emails.layout')
@section('content')
      @foreach($data['request'] as $k=>$value)
          <?php $label = trim(ucfirst(str_replace("_", " ", $k)));

          if(is_numeric(strpos($label, "My name"))){
              continue;
          }

          if(is_numeric(strpos($label, "Honeypot"))){
              continue;
          }

          if($k == "product_id"){
              $label = "Prodotto";
              $product = \App\Models\PluginProducts::find($value);
              if($product){
                  $value = "$product->name ($product->sku)";
              }
          }
          ?>
          @if(is_array($value))
              <p><strong>{{ $label }}:</strong></p>
              <ul>
              @foreach($value as $v)
                <li>{{ $v }}</li>
              @endforeach
              </ul>
          @else
              @if(!in_array($label, ['G-recaptcha-response', 'Valid from']))
                  @if($label == "File")
                      <?php
                      $basename = basename($value);
                      ?>
                      <p><strong>{{ $label }}:</strong> <a href="{{ $value }}">{{ $basename }}</a> </p>
                  @else
                      @if($value == "1")
                          <p><strong>{{ $label }}:</strong> SI</p>
                      @else
                          <p><strong>{{ $label }}:</strong> {{ $value }}</p>
                      @endif
                  @endif


              @endif
          @endif
      @endforeach
@endsection
