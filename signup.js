async function signupUser() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('signupPassword').value.trim();
  
    if (!name || !email || !password) {
      alert('Please fill all fields');
      return;
    }
  
    try {
      const response = await fetch('http://localhost:3000/signup', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, email, password })
      });
  
      const result = await response.json();
  
      if (response.ok) {
        alert(result.message || 'Signup successful!');
        window.location.href = 'login.html'; // Redirect to login page
      } else {
        alert(result.message || 'Signup failed. Try again.');
      }
  
    } catch (error) {
      console.error('Error during signup:', error);
      alert('Something went wrong. Please try again.');
    }
  }
  
