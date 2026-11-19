// ============================================================
//  Simulador de golpe: una raqueta de pádel que sigue el mouse/dedo
//  y, al tocar "Simular golpe", le pega a la pelota y actualiza las estadísticas.
// ============================================================
(function () {
  const st = document.getElementById('simStage');
  if (!st) return;
  const rk = document.getElementById('rk'), ball = document.getElementById('ball'),
        heat = document.getElementById('heat'), imp = document.getElementById('imp'), tag = document.getElementById('tagt');
  const out = { g: document.getElementById('sGolpes'), v: document.getElementById('sVel'),
                h: document.getElementById('sHr'), p: document.getElementById('sDulce') };
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const L = 260; // distancia del pivote (mango) al centro de la cara de la raqueta

  // a = ángulo del swing · s = de dónde viene la pelota · t = a dónde cae · c = curva · v = rango de km/h
  const SHOTS = {
    drive:   { a: 28,  s: [60, 40],  t: [335, 90],  c: [250, -30], v: [85, 120] },
    reves:   { a: -28, s: [340, 40], t: [65, 90],   c: [150, -30], v: [75, 110] },
    bandeja: { a: 12,  s: [330, 20], t: [130, 200], c: [300, 40],  v: [55, 80] },
    volea:   { a: 0,   s: [60, 120], t: [300, 210], c: [180, 70],  v: [45, 75] }
  };
  let shot = 'drive', busy = false, n = 0, dulces = 0, hr = 118, cur = 0, tgt = 0, raf = 0;

  const ease = t => t < .5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
  const quad = (a, c, b, t) => [(1 - t) * (1 - t) * a[0] + 2 * (1 - t) * t * c[0] + t * t * b[0],
                                (1 - t) * (1 - t) * a[1] + 2 * (1 - t) * t * c[1] + t * t * b[1]];
  const setAng = d => rk.setAttribute('transform', 'rotate(' + d + ' 200 450)');
  const rnd = (a, b) => a + Math.random() * (b - a);

  // ---- La raqueta sigue el puntero cuando no está pegando ----
  function tick() {
    raf = 0;
    if (busy) return;
    cur += (tgt - cur) * .18; setAng(cur);
    if (Math.abs(tgt - cur) > .05) raf = requestAnimationFrame(tick);
  }
  const kick = () => { if (!raf && !busy) raf = requestAnimationFrame(tick); };
  if (!reduce) {
    st.addEventListener('pointermove', e => {
      const r = st.getBoundingClientRect();
      tgt = ((e.clientX - r.left) / r.width - .5) * 40; kick();
    });
    st.addEventListener('pointerleave', () => { tgt = 0; kick(); });
  }

  // ---- Un golpe completo ----
  function go() {
    if (busy) return;
    busy = true;
    const S = SHOTS[shot], ar = S.a * Math.PI / 180;
    const dx = rnd(-30, 30), dy = rnd(-40, 40);                  // dónde pega en la cara
    const C = [200 + L * Math.sin(ar) + dx * Math.cos(ar) - dy * Math.sin(ar),
               450 - L * Math.cos(ar) + dx * Math.sin(ar) + dy * Math.cos(ar)];
    const dulce = Math.hypot(dx, dy + 15) < 24;                  // dentro del punto dulce
    const vel = Math.round(rnd(S.v[0], S.v[1]));
    const T1 = 520, T2 = 760, t0 = performance.now();
    let hit = false;
    imp.setAttribute('cx', 200 + dx); imp.setAttribute('cy', 190 + dy);

    (function f(now) {
      const t = now - t0; let ang, p, pos;
      if (t < T1) { p = ease(t / T1); ang = cur + (S.a - cur) * p; pos = quad(S.s, [(S.s[0] + C[0]) / 2, S.s[1] - 40], C, p); }
      else {
        p = Math.min((t - T1) / T2, 1); ang = S.a * (1 - ease(p)); pos = quad(C, S.c, S.t, p);
        if (!hit) { hit = true; imp.setAttribute('opacity', 1);
          tag.textContent = vel + ' km/h'; tag.setAttribute('x', Math.min(Math.max(C[0], 90), 310)); tag.setAttribute('y', Math.max(C[1] - 40, 50)); tag.setAttribute('opacity', 1); }
      }
      setAng(ang); ball.setAttribute('cx', pos[0]); ball.setAttribute('cy', pos[1]);
      if (t < T1 + T2) requestAnimationFrame(f); else fin();
    })(t0);

    function fin() {
      busy = false; cur = 0; setAng(0);
      imp.setAttribute('opacity', 0); tag.setAttribute('opacity', 0);
      n++; if (dulce) dulces++; hr = Math.min(hr + Math.round(rnd(2, 5)), 176);
      out.g.textContent = n; out.v.textContent = vel; out.h.textContent = hr; out.p.textContent = Math.round(dulces / n * 100) + '%';
      // mancha de "mapa de calor" donde cayó la pelota
      const c = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
      c.setAttribute('cx', S.t[0] + rnd(-12, 12)); c.setAttribute('cy', S.t[1] + rnd(-12, 12)); c.setAttribute('r', 34);
      c.setAttribute('fill', 'url(#hg)'); c.style.opacity = 0; c.style.transition = 'opacity .6s'; heat.appendChild(c);
      requestAnimationFrame(() => c.style.opacity = .85);
      if (heat.children.length > 10) heat.removeChild(heat.firstChild);
      ball.setAttribute('cx', -60); ball.setAttribute('cy', -60);
      kick();
    }
  }

  document.getElementById('simGo').addEventListener('click', go);
  st.addEventListener('click', go);
  document.querySelectorAll('#simShots [data-shot]').forEach(b => b.addEventListener('click', () => {
    shot = b.dataset.shot;
    document.querySelectorAll('#simShots [data-shot]').forEach(x => x.classList.toggle('on', x === b));
    go();
  }));

  // Un primer golpe de muestra cuando la sección aparece en pantalla
  if (!reduce && 'IntersectionObserver' in window) {
    const o = new IntersectionObserver(es => { if (es[0].isIntersecting) { o.disconnect(); setTimeout(go, 700); } }, { threshold: .6 });
    o.observe(st);
  }
})();
