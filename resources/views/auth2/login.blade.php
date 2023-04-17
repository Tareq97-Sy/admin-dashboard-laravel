<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<style>
    .login-container {
    display: flex;
    justify-content: center;
    margin-top: 160px; 
}
</style>
<div class="login-container">
<form class="form-signin" method="POST" action="/api/login">
@csrf      
<img class="mb-4" src="" alt="logo_img" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus >
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required autocomplete="new-password">
      <div class="checkbox mb-3">
        <!-- <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">© 2023-2024</p>
    </form>
  

<div class="betternet-wrapper"></div>
</div>
<script>
  const form = document.querySelector('form');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        // Save the token to local storage or a cookie
        localStorage.setItem('token', data.token);

        // Redirect the user to the main SPA page
        window.location.href = '/app';
    } catch (error) {
        console.error(error);
    }
});
</script>