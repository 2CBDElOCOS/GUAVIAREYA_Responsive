const eventDate = new Date('2024-08-10T00:00:00'); // Fecha del evento

const currentDate = new Date();

const timeDifference = eventDate - currentDate;

if (timeDifference <= 0) {
  // El evento ha comenzado
  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = '../css/evento.css';
  document.head.appendChild(link);
}

function updateCountdown() {
  const now = new Date().getTime();
  const distance = eventDate - now;

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "¡El evento ha comenzado!";
  }
}

const x = setInterval(updateCountdown, 1000);