<footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>
<script src="assets/pagination/jquery.simplePagination.js"></script>
  <script src="assets/js/bootstrap.min.js">
    
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="third-party/splide/dist/js/splide.min.js"></script>
</body>
<script>
  document.addEventListener( 'DOMContentLoaded', function() {
    var splide = new Splide( '.splide' );
    splide.mount();
  } );
</script>

<script>
  // Get the input range and the label element
  const inputRange = document.getElementById('customRange2');
  const yearLabel = document.getElementById('yearLabel');

  // Set the initial label text to the minimum year
  yearLabel.textContent = inputRange.min;

  // Update the label text as the user slides the range
  inputRange.addEventListener('input', function() {
    yearLabel.textContent = this.value;
  });
</script>
<script src="script.js"></script>
</html>