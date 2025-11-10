// =======================
// DraftoStation - Game JS
// =======================

// Utils
const $  = (s, r = document) => r.querySelector(s);
const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
const clampInt = (v, min, max, def) => {
  const n = parseInt(v, 10);
  return isNaN(n) ? def : Math.max(min, Math.min(max, n));
};

// ====== Endpoints (stateless) ======
const MOVE_ENDPOINT    = '/draftostation/move';
const RESULTS_ENDPOINT = '/draftostation/results';

// ====== Toast ligero (auto-dismiss) ======
(function ensureToastStyles(){
  if ($('#drafto-toast-styles')) return;
  const css = document.createElement('style');
  css.id = 'drafto-toast-styles';
  css.textContent = `
    .drafto-toast-wrap{position:fixed;z-index:9999;right:16px;bottom:16px;display:flex;flex-direction:column;gap:8px}
    .drafto-toast{
      min-width:260px; max-width:420px; padding:12px 14px; border-radius:10px;
      color:#fff; box-shadow:0 8px 32px rgba(0,0,0,.35); display:flex; align-items:flex-start; gap:10px;
      opacity:0; transform:translateY(8px); transition:opacity .15s ease, transform .15s ease;
      font-weight:600; line-height:1.35;
    }
    .drafto-toast.show{opacity:1; transform:translateY(0)}
    .drafto-toast .t-title{font-weight:800; margin-right:6px}
    .drafto-toast .t-close{margin-left:auto; background:transparent; border:0; color:inherit; opacity:.85; cursor:pointer}
    .drafto-toast.success{ background:#16a34a; }
    .drafto-toast.error{   background:#dc2626; }
    .drafto-toast.info{    background:#2563eb; }
  `;
  document.head.appendChild(css);
})();
function showToast({title='Listo', message='', type='info', duration=2200, onHidden=null} = {}){
  let wrap = $('.drafto-toast-wrap');
  if (!wrap){
    wrap = document.createElement('div');
    wrap.className = 'drafto-toast-wrap';
    document.body.appendChild(wrap);
  }
  const el = document.createElement('div');
  el.className = `drafto-toast ${type}`;
  el.innerHTML = `
    <span class="t-title">${title}</span>
    <span class="t-msg">${message}</span>
    <button class="t-close" aria-label="Cerrar">✕</button>
  `;
  wrap.appendChild(el);
  // mostrar
  requestAnimationFrame(() => el.classList.add('show'));

  let closed = false;
  const close = () => {
    if (closed) return;
    closed = true;
    el.classList.remove('show');
    setTimeout(() => { el.remove(); onHidden && onHidden(); }, 160);
  };
  el.querySelector('.t-close').addEventListener('click', close);
  if (duration > 0) setTimeout(close, duration);
  return { close };
}

// ====== API calls ======
async function sendMoveAndScore({ boardId, regionId, pieceType, pieceId, playerId }) {
  const res = await fetch(MOVE_ENDPOINT, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    credentials: 'omit',
    body: JSON.stringify({ boardId, regionId, pieceType, pieceId, playerId })
  });
  if (!res.ok) {
    const msg = await res.text().catch(() => '');
    throw new Error(`Error ${res.status}: ${msg || 'No se pudo registrar la jugada'}`);
  }
  const json = await res.json();
  if (typeof json.points !== 'number') {
    throw new Error('Respuesta inválida del servidor: falta "points"');
  }
  return json; // { points }
}

function buildMatchResultsPayload() {
  return {
    boardId: $('#boardRoot')?.getAttribute('data-board-id') || 'default',
    round: state.round,
    turn: state.turn,
    jugadores: state.players.map(p => ({
      nombre: p.name,
      puntos: Number(p.score || 0)
    }))
  };
}

async function sendMatchResults() {
  const payload = buildMatchResultsPayload();
  const res = await fetch(RESULTS_ENDPOINT, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
    credentials: 'omit',
    body: JSON.stringify(payload)
  });
  if (!res.ok) {
    const msg = await res.text().catch(()=> '');
    throw new Error(`Error ${res.status}: ${msg || 'No se pudo enviar resultados'}`);
  }
  return await res.json(); // p.ej. { saved:true, matchId:'...' }
}

// Paleta de colores determinística (orden fijo)
const PLAYER_COLORS = ['#ff6b6b', '#4ecdc4', '#feca57', '#5f27cd', '#10ac84', '#54a0ff', '#ff9ff3'];
let colorCursor = 0;
function nextColor() {
  const color = PLAYER_COLORS[colorCursor % PLAYER_COLORS.length];
  colorCursor++;
  return color;
}

// Estado
// Estado
const state = {
  players: [],
  active: 0,
  round: 1,
  turn: 1,
  dir: 'left',
  types: ['Atari','Gameboy','NES','Nintendo Switch','PlayStation 5','X-Box 360'],
  pool:  {
    'Atari': 10,
    'Gameboy': 10,
    'NES': 10,
    'Nintendo Switch': 10,  // <-- antes 'Nintendo'
    'PlayStation 5': 10,    // <-- antes 'PlayStation'
    'X-Box 360': 10
  },
  caps:  {circuito_uniforme:9999,taller:9999,llanura:9999,montana:9999,pantano:9999,desierto:9999,costa:9999}
};


function updateActivePlayerIndicator() {
  const el = $('#activePlayerIndicator');
  const p  = state.players[state.active];
  if (!el) return;
  if (p) {
    el.innerHTML = `Turno de <strong>${p.name}</strong>`;
    el.style.color = p.color;
  } else {
    el.textContent = '';
    el.style.color = '';
  }
}

function renderPlayersList() {
  const list = $('#playerList');
  list.innerHTML = '';
  state.players.forEach(p => {
    const pill = document.createElement('span');
    pill.className = 'player-pill';
    pill.textContent = p.name;
    pill.style.setProperty('--pill', p.color);
    pill.style.backgroundColor = p.color;
    pill.style.borderColor = p.color;
    list.appendChild(pill);
    list.appendChild(document.createTextNode(' '));
  });
}

function renderScore() {
  const tb = $('#scoreBody');
  tb.innerHTML = '';
  state.players.forEach((p) => {
    const tr  = document.createElement('tr');
    const td1 = document.createElement('td');
    const td2 = document.createElement('td');

    const dot = document.createElement('span');
    dot.className = 'legend-dot';
    dot.style.setProperty('--dot', p.color);
    dot.style.backgroundColor = p.color;

    td1.appendChild(dot);
    td1.appendChild(document.createTextNode(' ' + p.name));

    td2.className = 'text-end fw-semibold';
    td2.textContent = p.score;

    tr.appendChild(td1);
    tr.appendChild(td2);
    tb.appendChild(tr);
  });
}

function buildTokenTray() {
  const tray = $('#iconTray');
  tray.innerHTML = '';
  state.types.forEach(t => {
    const left = state.pool[t] ?? 0;
    if (left <= 0) return;
    const b = document.createElement('button');
    b.type = 'button';
    b.className = 'btn btn-sm token-btn token d-flex align-items-center gap-2';
    b.setAttribute('data-type', t);
    b.draggable = true;
    b.innerHTML = `<i class="bi bi-hexagon"></i> <span>${t}</span> <span class="badge bg-light text-dark">${left}</span>`;
    b.addEventListener('dragstart', e => {
      e.dataTransfer.setData('text/type', t);
    });
    tray.appendChild(b);
  });
}

function buildPlayersSelect() {
  const sel = $('#activePlayer');
  sel.innerHTML = '';
  state.players.forEach((p, i) => {
    const o = document.createElement('option');
    o.value = i;
    o.textContent = p.name;
    o.style.color = p.color;
    sel.appendChild(o);
  });
  if (state.players.length > 0) {
    sel.value = String(state.active);
  }
}

// -------- Init & Bind
function initUI() {
  buildPlayersSelect();
  renderPlayersList();
  buildTokenTray();
  renderScore();
  $('#roundInput').value = state.round;
  $('#turnInput').value = state.turn;
  updateActivePlayerIndicator();
}

// ====== UI helpers post-jugada ======
function placeChipOnZone({ zone, text, color }) {
  const chip = document.createElement('span');
  chip.className = 'badge me-1 mb-1 chip';
  chip.style.backgroundColor = color;
  chip.style.color = '#fff';
  chip.setAttribute('data-chip','1');
  chip.textContent = text;
  zone.appendChild(chip);
}

function consumeFromPool(type) {
  const remain = (state.pool[type] ?? 0);
  state.pool[type] = Math.max(0, remain - 1);
  const btn = document.querySelector(`#iconTray [data-type="${CSS.escape(type)}"]`);
  if (btn) {
    const badge = btn.querySelector('.badge');
    if (state.pool[type] <= 0) { btn.remove(); }
    else if (badge) { badge.textContent = String(state.pool[type]); }
  }
}

// -------- Binds y Drop async → server
function bindEvents() {
  // Dropzones
  $$('.dropzone').forEach(zone => {
    const region = zone.dataset.region;

    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));

    zone.addEventListener('drop', async e => {
      e.preventDefault();
      zone.classList.remove('dragover');

      if (state.players.length === 0) {
        showToast({ type:'error', title:'Falta jugador', message:'Agrega al menos un jugador.' });
        return;
      }

      const type = e.dataTransfer.getData('text/type');
      if (!type) return;

      const remain = (state.pool[type] ?? 0);
      if (remain <= 0) return;

      const cap   = state.caps[region] || 99;
      const count = zone.querySelectorAll('.badge[data-chip]')?.length || 0;
      if (count >= cap) return;

      const p = state.players[state.active];
      if (!p) return;

      const boardId = $('#boardRoot')?.getAttribute('data-board-id') || 'default';
      const pieceId = null;

      zone.setAttribute('aria-busy', 'true');

      try {
        const { points } = await sendMoveAndScore({
          boardId, regionId: region, pieceType: type, pieceId, playerId: p.name
        });

        p.board.push({ type, region });
        p.score = Number(p.score || 0) + Number(points || 0);

        consumeFromPool(type);
        placeChipOnZone({ zone, text: type, color: p.color });

        renderScore();
        nextTurn();

      } catch (err) {
        console.error(err);
        showToast({ type:'error', title:'Error', message:'No se pudo registrar la jugada.' });
      } finally {
        zone.removeAttribute('aria-busy');
      }
    });
  });

  // Agregar jugador
  $('#btnAddPlayer').addEventListener('click', () => {
    const name = $('#newPlayerName').value.trim();
    if (!name) return showToast({ type:'info', title:'Atención', message:'Ingrese un nombre.' });
    if (state.players.length >= 6) return showToast({ type:'info', title:'Límite', message:'Máximo 6 jugadores.' });
    if (state.players.some(p => p.name.toLowerCase() === name.toLowerCase()))
      return showToast({ type:'info', title:'Duplicado', message:'Ese nombre ya existe.' });

    const color = nextColor();
    state.players.push({ name, score: 0, board: [], color });

    $('#newPlayerName').value = '';
    if (state.players.length === 1) state.active = 0;

    initUI();
  });

  // Panel izq
  $('#activePlayer').addEventListener('change', e => {
    const idx = parseInt(e.target.value, 10);
    if (!Number.isNaN(idx)) state.active = idx;
    updateActivePlayerIndicator();
  });
  $('#roundInput').addEventListener('input', e => { state.round = clampInt(e.target.value, 1, 99, 1); });
  $('#turnInput').addEventListener('input', e => { state.turn  = clampInt(e.target.value, 1, 99, 1); });
  

  // NUEVO: Enviar resultados
  const sendBtn = $('#btnSendResults');
  if (sendBtn) {
    sendBtn.addEventListener('click', async () => {
      if (state.players.length === 0) {
        showToast({ type:'info', title:'Nada que enviar', message:'No hay jugadores cargados.' });
        return;
      }
      try {
        await sendMatchResults();
        showToast({
          type:'success',
          title:'Guardado',
          message:'Resultados enviados correctamente.',
          duration:1800,
          onHidden: () => { reset(); }
        });
      } catch (err) {
        console.error(err);
        showToast({ type:'error', title:'Error', message:'No se pudieron enviar los resultados.' });
      }
    });
  }
}

// -------- Lógica de puntaje local (no usada para sumar en flujo async)
function autoScoreFor(player) {
  const byRegion = {circuito_uniforme:[],pixeles_variados:[],cuartel_multijugador:[],triple_a:[],consola_del_año:[],edicion_limitada:[],taller:[]};
  player.board.forEach(it => { (byRegion[it.region] = byRegion[it.region] || []).push(it.type); });
  let pts = 0;
  if (byRegion.circuito_uniforme.length) { const c=countBy(byRegion.circuito_uniforme); const m=Math.max(...Object.values(c)); pts += m*m; }
  if (byRegion.pixeles_variados.length)    { const c=countBy(byRegion.pixeles_variados);    Object.values(c).forEach(n => pts += Math.floor(n/2)*3); }
  if (byRegion.cuartel_multijugador.length){ pts += (new Set(byRegion.cuartel_multijugador)).size*2; }
  if (byRegion.triple_a.length){ pts += byRegion.triple_a.length + byRegion.triple_a.filter(t => t === 'Atari').length*2; }
  if (byRegion.consola_del_año.length){ const c=countBy(byRegion.consola_del_año); const types=Object.keys(c).length; const dups=Object.values(c).reduce((a,n)=>a+(n-1),0); pts += types*2 - dups; }
  pts += byRegion.edicion_limitada.length + byRegion.taller.length;
  return pts;
}
const countBy = (arr) => arr.reduce((a,k) => (a[k] = (a[k]||0) + 1, a), {});

// -------- Turnos & Reset
function nextTurn() {
  if (state.players.length === 0) return;
  state.turn++;
  state.active = (state.active + 1) % state.players.length;
  const sel = $('#activePlayer');
  if (sel) sel.value = String(state.active);
  renderScore();
  updateActivePlayerIndicator();
}



// -------- Arranque
document.addEventListener('DOMContentLoaded', () => {
  initUI();
  bindEvents();
});
