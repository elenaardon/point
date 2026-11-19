// Solo cambia entre las pestañas "Crear cuenta" / "Iniciar sesión" (el envío lo procesa PHP).
const reg=document.getElementById('f-reg'),log=document.getElementById('f-log'),tr=document.getElementById('t-reg'),tl=document.getElementById('t-log');
if(reg&&log){
  const tab=r=>{reg.hidden=!r;log.hidden=r;tr.setAttribute('aria-selected',r);tl.setAttribute('aria-selected',!r)};
  tr.onclick=()=>tab(true);tl.onclick=()=>tab(false);
}
