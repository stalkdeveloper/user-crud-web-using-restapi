<!-- Vendor js -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('backend/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('backend/vendor/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('backend/js/app.min.js') }}"></script>


<script src="{{ asset('backend/js/custom.js') }}"></script>

<script>
    $(document).ready(function() {
      $('.featureSelect').select2({
        templateResult: function(data) {
          if (!data.id) {
            return data.text;
          }
          // Customize the option display
          return $('<span class="checkBoxFlex"><div class="form-check"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></div><div class="custom-option">' + data.text + '</div></span>');
        },
        templateSelection: function(data) {
          return data.text;
        }
      });
    });
</script>

@include('backend.partials.alert')