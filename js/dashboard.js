window.addEventListener('load', () => {
  setTimeout(() => {
    document.getElementById('loader').classList.add('hide');
  }, 1000);
});

const particlesContainer = document.getElementById('particles');
for (let i = 0; i < 30; i++) {
  const particle = document.createElement('div');
  particle.className = 'particle';
  particle.style.left = Math.random() * 100 + '%';
  particle.style.top = Math.random() * 100 + '%';
  particle.style.animationDelay = Math.random() * 20 + 's';
  particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
  particlesContainer.appendChild(particle);
}

const options = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.animationPlayState = 'running';
    }
  });
}, options);

document.querySelectorAll('.stat-card, .election-card').forEach(card => {
  card.style.animationPlayState = 'paused';
  observer.observe(card);
});

function animateValue(element, start, end, duration) {
  let startTime = null;
  const step = (timestamp) => {
    if (!startTime) startTime = timestamp;
    const progress = Math.min((timestamp - startTime) / duration, 1);
    const value = Math.floor(progress * (end - start) + start);
    element.textContent = value + (element.dataset.suffix || '');
    if (progress < 1) {
      window.requestAnimationFrame(step);
    }
  };
  window.requestAnimationFrame(step);
}

setTimeout(() => {
  document.querySelectorAll('.stat-number').forEach((num, index) => {
    const target = parseInt(num.textContent);
    num.textContent = '0';
    setTimeout(() => {
      animateValue(num, 0, target, 1500);
    }, index * 200);
  });
}, 1200);

document.querySelectorAll('.stat-card, .action-item, .election-card').forEach(card => {
  card.addEventListener('mouseenter', () => {
    card.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
  });
});

document.querySelectorAll('.vote-btn').forEach(btn => {
  btn.addEventListener('click', (e) => {
    if (btn.disabled) return;

    const ripple = document.createElement('span');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = e.clientX - rect.left - size / 2;
    const y = e.clientY - rect.top - size / 2;

    ripple.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      border-radius: 50%;
      background: rgba(255,255,255,0.6);
      left: ${x}px;
      top: ${y}px;
      pointer-events: none;
      transform: scale(0);
      animation: ripple 0.6s ease-out;
`;

    btn.style.position = 'relative';
    btn.style.overflow = 'hidden';
    btn.appendChild(ripple);

    setTimeout(() => ripple.remove(), 600);
  });
});

const rippleStyle = document.createElement('style');
rippleStyle.innerHTML = `
@keyframes ripple {
  to {
    transform: scale(2);
    opacity: 0;
  }
}
`;
document.head.appendChild(rippleStyle);

console.log('🗳️ Digital Voting System Dashboard Loaded!');
console.log('👨‍💻 Developed by: Gulshan Kushwaha');
