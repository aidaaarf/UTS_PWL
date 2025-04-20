{{-- <!-- Bagian breadcrumb di layout (misalnya di app.blade.php) -->
<div class="breadcrumb-container">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <!-- Cek apakah breadcrumb ada -->
          @if(isset($breadcrumb))
              @foreach($breadcrumb->list as $item)
                  <li class="breadcrumb-item">
                      <!-- Jika item terakhir, tampilkan sebagai teks biasa -->
                      @if($loop->last)
                          <span>{{ $item }}</span>
                      @else
                          <a href="#">{{ $item }}</a>
                      @endif
                  </li>
              @endforeach
          @endif
      </ol>
  </nav>
</div> --}}
