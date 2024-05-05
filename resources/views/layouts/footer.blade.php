<footer class="container-fluid bg-body-tertiary {{ $fixedBottom ?? 'fixed-bottom' }}">
  <div class="row text-center pt-2 pb-2">
      <div class="col-md-4 mb-2">
          <p>&copy; {{ __('name_page') }} &ndash; 2024</p>
      </div>
      <div class="col-md-4 mb-2" style="
      display: flex;
  ">
          <a href="https://facebook.com" target="_blank" class="text-decoration-none red-after">
              <i class="bi bi-facebook" style="font-size: 24px;"></i>
          </a>
          <a href="https://twitter.com" target="_blank" class="text-decoration-none ms-3 red-after">
              <i class="bi bi-twitter" style="font-size: 24px;"></i>
          </a>
          <a href="https://instagram.com" target="_blank" class="text-decoration-none ms-3 red-after">
              <i class="bi bi-instagram" style="font-size: 24px;"></i>
          </a>
          <a href="https://linkedin.com" target="_blank" class="text-decoration-none ms-3 red-after">
              <i class="bi bi-linkedin" style="font-size: 24px;"></i>
          </a>
      </div>
      <div class="col-md-4 mb-2">
          <a href="mailto:rentalVOD@contact.com">
              <i class="bi bi-envelope-fill red-after" style="font-size: 20px;"></i> rentalVOD@contact.com
          </a>
      </div>
  </div>
</footer>

<script>
  window.onload = function(e){
      var toastElList = [].slice.call(document.querySelectorAll('.toast'))
      var toastList = toastElList.map(function(toastEl) {
          return new bootstrap.Toast(toastEl)
      });
      toastList.forEach(toast => toast.show());
  }
</script>
