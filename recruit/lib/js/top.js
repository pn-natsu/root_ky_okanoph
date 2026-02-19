


// #header .logoをh1に変更
document.addEventListener('DOMContentLoaded', function () {
  const logo = document.querySelector('#header .logo');
  if (!logo) return;

  const link = logo.querySelector('a');
  if (!link) return;

  const img = link.querySelector('img');
  if (!img) return;

  const h1 = document.createElement('h1');
  h1.className = 'site-title';

  link.replaceWith(h1);
  h1.appendChild(img);
});
