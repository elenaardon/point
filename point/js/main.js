// ---- Menú hamburguesa ----
const b=document.querySelector('.burger'),m=document.getElementById('menu');
function t(o){m.classList.toggle('on',o);b.setAttribute('aria-expanded',o)}
b.onclick=()=>t(!m.classList.contains('on'));m.querySelectorAll('a').forEach(a=>a.onclick=()=>t(false));

// ---- Animaciones al hacer scroll: los elementos .rv aparecen suavemente ----
const reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const rv=document.querySelectorAll('.rv');
if(reduce||!('IntersectionObserver' in window)){rv.forEach(e=>e.classList.add('in'))}
else{
  const io=new IntersectionObserver(es=>es.forEach(en=>{if(en.isIntersecting){en.target.classList.add('in');io.unobserve(en.target);setTimeout(()=>{en.target.style.transitionDelay=''},1400)}}),{threshold:.15});
  rv.forEach((e,i)=>{e.style.transitionDelay=((i%4)*70)+'ms';io.observe(e)});
}

// ---- Contadores: <b data-count="1482">0</b> sube hasta el número al aparecer ----
document.querySelectorAll('[data-count]').forEach(el=>{
  const fin=+el.dataset.count,dec=+(el.dataset.dec||0);
  const fmt=v=>v.toLocaleString('es-AR',{minimumFractionDigits:dec,maximumFractionDigits:dec})+(el.dataset.suf||'');
  if(reduce||!('IntersectionObserver' in window)){el.textContent=fmt(fin);return}
  const o=new IntersectionObserver(es=>{if(!es[0].isIntersecting)return;o.disconnect();
    const t0=performance.now();(function f(n){const p=Math.min((n-t0)/1200,1);el.textContent=fmt(fin*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(f)})(t0)},{threshold:.5});
  o.observe(el);
});
