/* ============================================
   SMARTBIZ RETAIL MANAGEMENT SYSTEM — app.js
   ============================================ */
 
// =================== DATA STORE ===================
const DB = {
  currentUser: null,
  customers: [
    {id:1,name:'Alice Johnson',email:'alice@example.com',phone:'+1 555-0101',address:'42 Oak St, Springfield',registered:'2024-01-15',purchases:14},
    {id:2,name:'Bob Martinez',email:'bob@example.com',phone:'+1 555-0102',address:'88 Pine Ave, Shelbyville',registered:'2024-02-03',purchases:7},
    {id:3,name:'Carol Williams',email:'carol@example.com',phone:'+1 555-0103',address:'13 Elm Rd, Ogdenville',registered:'2024-03-21',purchases:23},
    {id:4,name:'David Chen',email:'david@example.com',phone:'+1 555-0104',address:'77 Maple Dr, Brockway',registered:'2024-04-08',purchases:3},
    {id:5,name:'Eva Rodriguez',email:'eva@example.com',phone:'+1 555-0105',address:'5 Cedar Ln, Capital City',registered:'2024-05-14',purchases:18},
    {id:6,name:'Frank Lee',email:'frank@example.com',phone:'+1 555-0106',address:'321 Birch Blvd, North Haverbrook',registered:'2024-06-01',purchases:9},
    {id:7,name:'Grace Kim',email:'grace@example.com',phone:'+1 555-0107',address:'654 Walnut Way, Waverly Hills',registered:'2024-07-22',purchases:31},
    {id:8,name:'Henry Brown',email:'henry@example.com',phone:'+1 555-0108',address:'987 Spruce Ct, Cypress Creek',registered:'2024-08-11',purchases:5},
  ],
  products: [
    {id:1,name:'Wireless Headphones Pro',sku:'ELC-001',category:'Electronics',price:129.99,qty:45,supplier:'TechSupply Co',desc:'Premium noise-cancelling headphones'},
    {id:2,name:'Running Shoes X3',sku:'SPT-002',category:'Sports',price:89.50,qty:8,supplier:'SportGear Ltd',desc:'Lightweight performance running shoes'},
    {id:3,name:'Organic Green Tea',sku:'FBV-003',category:'Food & Beverage',price:14.99,qty:200,supplier:'NatureFarm',desc:'Premium loose leaf green tea'},
    {id:4,name:'Smart Watch Series 5',sku:'ELC-004',category:'Electronics',price:299.99,qty:3,supplier:'TechSupply Co',desc:'Advanced fitness & health tracking'},
    {id:5,name:'Yoga Mat Premium',sku:'SPT-005',category:'Sports',price:45.00,qty:62,supplier:'FitLife Inc',desc:'Eco-friendly non-slip yoga mat'},
    {id:6,name:'Vitamin C Complex',sku:'HLT-006',category:'Health',price:24.99,qty:0,supplier:'HealthPros',desc:'High potency vitamin C supplements'},
    {id:7,name:'Denim Jacket Classic',sku:'CLT-007',category:'Clothing',price:75.00,qty:29,supplier:'FashionHub',desc:'Timeless denim jacket for all seasons'},
    {id:8,name:'Garden Hose 50ft',sku:'HGR-008',category:'Home & Garden',price:39.99,qty:5,supplier:'GardenWorld',desc:'Heavy-duty flexible garden hose'},
    {id:9,name:'Bluetooth Speaker',sku:'ELC-009',category:'Electronics',price:59.99,qty:38,supplier:'TechSupply Co',desc:'360° sound portable speaker'},
    {id:10,name:'Protein Powder Vanilla',sku:'HLT-010',category:'Health',price:49.99,qty:7,supplier:'HealthPros',desc:'Whey protein isolate 2kg'},
  ],
  sales: [
    {id:1,invoice:'INV-0038',customerId:1,customerName:'Alice Johnson',items:[{productId:1,name:'Wireless Headphones Pro',qty:1,price:129.99}],subtotal:129.99,discount:0,tax:19.50,total:149.49,method:'card',notes:'',date:'2025-05-10'},
    {id:2,invoice:'INV-0039',customerId:3,customerName:'Carol Williams',items:[{productId:3,name:'Organic Green Tea',qty:3,price:14.99},{productId:5,name:'Yoga Mat Premium',qty:1,price:45.00}],subtotal:89.97,discount:5,tax:12.75,total:98.72,method:'cash',notes:'',date:'2025-05-10'},
    {id:3,invoice:'INV-0040',customerId:7,customerName:'Grace Kim',items:[{productId:4,name:'Smart Watch Series 5',qty:2,price:299.99}],subtotal:599.98,discount:10,tax:80.99,total:620.97,method:'transfer',notes:'Corporate purchase',date:'2025-05-09'},
    {id:4,invoice:'INV-0041',customerId:2,customerName:'Bob Martinez',items:[{productId:7,name:'Denim Jacket Classic',qty:1,price:75.00}],subtotal:75.00,discount:0,tax:11.25,total:86.25,method:'card',notes:'',date:'2025-05-09'},
    {id:5,invoice:'INV-0042',customerId:5,customerName:'Eva Rodriguez',items:[{productId:9,name:'Bluetooth Speaker',qty:2,price:59.99},{productId:10,name:'Protein Powder Vanilla',qty:1,price:49.99}],subtotal:169.97,discount:0,tax:25.50,total:195.47,method:'cash',notes:'',date:'2025-05-08'},
  ],
  cart: [],
  categories: ['Electronics','Clothing','Food & Beverage','Home & Garden','Sports','Health'],
  nextCustomerId: 9,
  nextProductId: 11,
  nextSaleId: 6,
  nextInvoiceNum: 43,
  charts: {},
  currentPage: {customers: 1, products: 1},
  pageSize: 6,
  filters: {customers: '', products: '', category: ''},
  currentView: 'dashboard',
  sidebarCollapsed: false,
};
 
// =================== AUTH ===================
function doLogin() {
  const email = document.getElementById('loginEmail').value;
  const pass = document.getElementById('loginPassword').value;
  if (!email || !pass) { showToast('Please fill in all fields','error'); return; }
  const btn = document.querySelector('.btn-login');
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
  btn.disabled = true;
  setTimeout(() => {
    const role = email.includes('manager') ? 'manager' : email.includes('staff') ? 'staff' : 'admin';
    DB.currentUser = { name: 'Administrator', email, role, avatar: 'A' };
    if (role === 'manager') DB.currentUser = { ...DB.currentUser, name: 'Manager User', avatar: 'M' };
    if (role === 'staff') DB.currentUser = { ...DB.currentUser, name: 'Staff User', avatar: 'S' };
    document.getElementById('loginScreen').style.opacity = '0';
    document.getElementById('loginScreen').style.transform = 'scale(.98)';
    setTimeout(() => {
      document.getElementById('loginScreen').classList.add('hidden');
      document.getElementById('mainApp').classList.remove('hidden');
      initApp();
    }, 400);
    btn.innerHTML = '<span>Sign In</span><i class="fas fa-arrow-right"></i>';
    btn.disabled = false;
  }, 1200);
}
 
function quickLogin(role) {
  document.getElementById('loginEmail').value = `${role}@smartbiz.com`;
  document.getElementById('loginPassword').value = 'password';
  doLogin();
}
 
function doLogout() {
  if (confirm('Are you sure you want to logout?')) {
    document.getElementById('mainApp').style.opacity = '0';
    setTimeout(() => {
      document.getElementById('mainApp').classList.add('hidden');
      document.getElementById('mainApp').style.opacity = '1';
      document.getElementById('loginScreen').classList.remove('hidden');
      document.getElementById('loginScreen').style.opacity = '1';
      document.getElementById('loginScreen').style.transform = '';
      DB.currentUser = null;
    }, 400);
  }
}
 
function togglePass() {
  const input = document.getElementById('loginPassword');
  const icon = document.getElementById('eyeIcon');
  if (input.type === 'password') { input.type = 'text'; icon.className = 'fas fa-eye-slash'; }
  else { input.type = 'password'; icon.className = 'fas fa-eye'; }
}
 
// =================== INIT ===================
function initApp() {
  const u = DB.currentUser;
  document.getElementById('sidebarAvatar').textContent = u.avatar;
  document.getElementById('sidebarName').textContent = u.name;
  document.getElementById('sidebarRole').innerHTML = `<span class="role-badge ${u.role}">${u.role.charAt(0).toUpperCase()+u.role.slice(1)}</span>`;
  document.getElementById('topbarAvatar').textContent = u.avatar;
  document.getElementById('topbarName').textContent = u.name;
  document.getElementById('profileName').value = u.name;
  document.getElementById('profileEmail').value = u.email;
  document.getElementById('profileRole').value = u.role.charAt(0).toUpperCase()+u.role.slice(1);
  document.getElementById('avatarPreview').textContent = u.avatar;
  navigate('dashboard', document.querySelector('.nav-item'));
}
 
// =================== NAVIGATION ===================
function navigate(view, el) {
  document.querySelectorAll('.page-view').forEach(v => v.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  const target = document.getElementById(`view-${view}`);
  if (target) target.classList.add('active');
  if (el) el.classList.add('active');
  document.getElementById('pageTitle').textContent = view.charAt(0).toUpperCase()+view.slice(1);
  document.getElementById('breadcrumb').textContent = `Home / ${view.charAt(0).toUpperCase()+view.slice(1)}`;
  DB.currentView = view;
  closeAllDropdowns();
  if (view === 'dashboard') initDashboard();
  if (view === 'customers') renderCustomers();
  if (view === 'inventory') renderInventory();
  if (view === 'sales') initSales();
  if (view === 'reports') {}
  if (window.innerWidth <= 900) { document.getElementById('sidebar').classList.remove('mobile-open'); }
}
 
// =================== DASHBOARD ===================
function initDashboard() {
  renderRecentTrans();
  renderAlerts();
  renderActivity();
  setTimeout(() => {
    initRevenueChart();
    initCategoryChart();
    initSparklines();
  }, 50);
}
 
function renderRecentTrans() {
  const tbody = document.getElementById('recentTrans');
  tbody.innerHTML = DB.sales.slice().reverse().slice(0,5).map(s => `
    <tr>
      <td><span style="color:var(--accent);font-weight:600">${s.invoice}</span></td>
      <td>${s.customerName}</td>
      <td>${s.items.length} item${s.items.length>1?'s':''}</td>
      <td><strong>$${s.total.toFixed(2)}</strong></td>
      <td><span class="badge ${s.method==='card'?'badge-info':s.method==='cash'?'badge-success':'badge-warning'}">${s.method}</span></td>
      <td>${s.date}</td>
    </tr>`).join('');
}
 
function renderAlerts() {
  const lowStock = DB.products.filter(p => p.qty > 0 && p.qty <= 10);
  const outStock = DB.products.filter(p => p.qty === 0);
  const container = document.getElementById('inventoryAlerts');
  const all = [...outStock.map(p=>({...p,type:'out'})), ...lowStock.map(p=>({...p,type:'low'}))];
  document.getElementById('alertCount').textContent = all.length;
  document.getElementById('invBadge').textContent = all.length;
  container.innerHTML = all.length ? all.map(p => `
    <div class="alert-item">
      <div class="alert-icon ${p.type==='out'?'red':''}"><i class="fas fa-${p.type==='out'?'ban':'exclamation-triangle'}"></i></div>
      <div class="alert-text"><strong>${p.name}</strong><small>${p.sku}</small></div>
      <div class="stock-num ${p.type==='out'?'red':''}">${p.type==='out'?'Out of Stock':p.qty+' left'}</div>
    </div>`).join('') : '<div style="padding:20px;text-align:center;color:var(--text-muted)">No alerts</div>';
}
 
function renderActivity() {
  const acts = [
    {icon:'fa-user-plus',bg:'rgba(99,102,241,.15)',color:'#a5b4fc',text:'New customer <strong>Grace Kim</strong> registered',time:'2 min ago'},
    {icon:'fa-receipt',bg:'rgba(16,185,129,.15)',color:'#6ee7b7',text:'Sale <strong>INV-0042</strong> completed — $195.47',time:'15 min ago'},
    {icon:'fa-boxes-stacked',bg:'rgba(245,158,11,.15)',color:'#fcd34d',text:'Product <strong>Wireless Headphones Pro</strong> updated',time:'1 hour ago'},
    {icon:'fa-exclamation-triangle',bg:'rgba(239,68,68,.15)',color:'#fca5a5',text:'Low stock alert: <strong>Smart Watch Series 5</strong>',time:'2 hours ago'},
    {icon:'fa-user-edit',bg:'rgba(139,92,246,.15)',color:'#c4b5fd',text:'Customer <strong>Alice Johnson</strong> profile edited',time:'3 hours ago'},
    {icon:'fa-sign-in-alt',bg:'rgba(99,102,241,.15)',color:'#a5b4fc',text:'Admin logged in from 192.168.1.1',time:'Today, 9:00 AM'},
  ];
  document.getElementById('activityLog').innerHTML = acts.map(a => `
    <div class="activity-item">
      <div class="activity-icon" style="background:${a.bg};color:${a.color}"><i class="fas ${a.icon}"></i></div>
      <div class="activity-body"><p>${a.text}</p><small>${a.time}</small></div>
    </div>`).join('');
}
 
function initRevenueChart() {
  const ctx = document.getElementById('revenueChart');
  if (!ctx) return;
  if (DB.charts.revenue) { DB.charts.revenue.destroy(); }
  const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const data = [42000,38000,51000,47000,63000,58000,72000,68000,75000,81000,77000,84320];
  DB.charts.revenue = new Chart(ctx, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'Revenue',
        data,
        borderColor: '#6366f1',
        backgroundColor: 'rgba(99,102,241,0.08)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#6366f1',
        pointRadius: 4,
        pointHoverRadius: 7,
      },{
        label: 'Target',
        data: [45000,45000,55000,55000,65000,65000,70000,70000,75000,75000,80000,80000],
        borderColor: 'rgba(139,92,246,.4)',
        backgroundColor: 'transparent',
        borderDash: [5,5],
        tension: 0.4,
        pointRadius: 0,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
      scales: {
        x: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#5a5e7a' } },
        y: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#5a5e7a', callback: v => '$'+v.toLocaleString() } }
      }
    }
  });
}
 
function initCategoryChart() {
  const ctx = document.getElementById('categoryChart');
  if (!ctx) return;
  if (DB.charts.category) DB.charts.category.destroy();
  DB.charts.category = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Electronics','Clothing','Food & Bev','Sports','Health','Home & Garden'],
      datasets: [{ data: [38,22,15,12,8,5], backgroundColor: ['#6366f1','#8b5cf6','#10b981','#f59e0b','#ec4899','#3b82f6'], borderWidth: 0, hoverOffset: 8 }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom', labels: { color: '#8b8fa8', padding: 16, font: { size: 12 } } } },
      cutout: '65%'
    }
  });
}
 
function initSparklines() {
  const sparkData = {
    sparkCustomers: [180,195,200,210,220,235,248],
    sparkProducts: [1100,1150,1180,1200,1230,1260,1284],
    sparkSales: [3200,3350,3450,3600,3700,3800,3892],
    sparkRevenue: [62000,68000,72000,75000,79000,82000,84320],
  };
  Object.entries(sparkData).forEach(([id, data]) => {
    const ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
      type: 'line',
      data: { labels: data.map((_,i)=>i), datasets: [{ data, borderColor: 'rgba(255,255,255,.6)', borderWidth: 2, fill: false, tension: 0.4, pointRadius: 0 }] },
      options: { responsive: true, plugins: { legend: { display: false }, tooltip: { enabled: false } }, scales: { x: { display: false }, y: { display: false } }, animation: { duration: 1000 } }
    });
  });
}
 
function switchChart(el, period) {
  document.querySelectorAll('.chart-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  const datasets = {
    monthly: [42000,38000,51000,47000,63000,58000,72000,68000,75000,81000,77000,84320],
    weekly: [18000,21000,19500,23000,22000,25000,27000],
    daily: [2800,3100,2600,3400,2900,3800,4100],
  };
  const labels = {
    monthly: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    weekly: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
    daily: ['6am','8am','10am','12pm','2pm','4pm','6pm'],
  };
  if (DB.charts.revenue) {
    DB.charts.revenue.data.labels = labels[period];
    DB.charts.revenue.data.datasets[0].data = datasets[period];
    DB.charts.revenue.data.datasets[1].data = datasets[period].map(v => v * .9);
    DB.charts.revenue.update();
  }
}
 
// =================== CUSTOMERS ===================
function renderCustomers() {
  const filter = DB.filters.customers.toLowerCase();
  const filtered = DB.customers.filter(c =>
    c.name.toLowerCase().includes(filter) ||
    c.email.toLowerCase().includes(filter) ||
    c.phone.includes(filter)
  );
  const page = DB.currentPage.customers;
  const size = DB.pageSize;
  const total = Math.ceil(filtered.length / size);
  const paged = filtered.slice((page-1)*size, page*size);
  document.getElementById('customersTbody').innerHTML = paged.length ? paged.map(c => `
    <tr>
      <td><span style="color:var(--text-muted);font-size:12px">#${c.id}</span></td>
      <td>
        <div style="display:flex;align-items:center;gap:10px">
          <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0">${c.name.charAt(0)}</div>
          <div><strong>${c.name}</strong></div>
        </div>
      </td>
      <td>${c.email}</td>
      <td>${c.phone}</td>
      <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${c.address}</td>
      <td>${c.registered}</td>
      <td><span class="badge badge-info">${c.purchases} orders</span></td>
      <td>
        <div class="actions">
          <button class="btn-icon view" onclick="viewCustomer(${c.id})" title="View"><i class="fas fa-eye"></i></button>
          <button class="btn-icon edit" onclick="editCustomer(${c.id})" title="Edit"><i class="fas fa-pen"></i></button>
          <button class="btn-icon del" onclick="deleteCustomer(${c.id})" title="Delete"><i class="fas fa-trash"></i></button>
        </div>
      </td>
    </tr>`).join('') : '<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted)">No customers found</td></tr>';
  document.getElementById('statCustomers').textContent = DB.customers.length;
  document.getElementById('custBadge').textContent = DB.customers.length;
  renderPagination('custPagination', page, total, 'customers');
}
 
function filterCustomers(val) { DB.filters.customers = val; DB.currentPage.customers = 1; renderCustomers(); }
 
function saveCustomer() {
  const name = document.getElementById('cName').value.trim();
  const email = document.getElementById('cEmail').value.trim();
  if (!name || !email) { showToast('Name and email are required','error'); return; }
  DB.customers.push({ id: DB.nextCustomerId++, name, email, phone: document.getElementById('cPhone').value, address: document.getElementById('cAddress').value, registered: new Date().toISOString().split('T')[0], purchases: 0 });
  closeModal(); renderCustomers(); populateSaleDropdowns();
  showToast(`Customer "${name}" added successfully!`, 'success');
  document.getElementById('cName').value = ''; document.getElementById('cEmail').value = ''; document.getElementById('cPhone').value = ''; document.getElementById('cAddress').value = '';
}
 
function editCustomer(id) {
  const c = DB.customers.find(x => x.id === id);
  if (!c) return;
  document.getElementById('editCId').value = id;
  document.getElementById('editCName').value = c.name;
  document.getElementById('editCEmail').value = c.email;
  document.getElementById('editCPhone').value = c.phone;
  document.getElementById('editCAddress').value = c.address;
  openModal('editCustomer');
}
 
function updateCustomer() {
  const id = parseInt(document.getElementById('editCId').value);
  const c = DB.customers.find(x => x.id === id);
  if (!c) return;
  c.name = document.getElementById('editCName').value;
  c.email = document.getElementById('editCEmail').value;
  c.phone = document.getElementById('editCPhone').value;
  c.address = document.getElementById('editCAddress').value;
  closeModal(); renderCustomers();
  showToast('Customer updated successfully!', 'success');
}
 
function deleteCustomer(id) {
  const c = DB.customers.find(x => x.id === id);
  if (!c) return;
  if (confirm(`Delete customer "${c.name}"? This action cannot be undone.`)) {
    DB.customers = DB.customers.filter(x => x.id !== id);
    renderCustomers(); populateSaleDropdowns();
    showToast('Customer deleted.', 'warning');
  }
}
 
function viewCustomer(id) {
  const c = DB.customers.find(x => x.id === id);
  const purchases = DB.sales.filter(s => s.customerId === id);
  const totalSpent = purchases.reduce((sum, s) => sum + s.total, 0);
  showToast(`${c.name} — ${c.purchases} orders, $${totalSpent.toFixed(2)} spent`, 'info');
}
 
// =================== INVENTORY ===================
function renderInventory() {
  const filter = DB.filters.products.toLowerCase();
  const cat = DB.filters.category;
  const filtered = DB.products.filter(p =>
    (p.name.toLowerCase().includes(filter) || p.sku.toLowerCase().includes(filter)) &&
    (!cat || p.category === cat)
  );
  const page = DB.currentPage.products;
  const size = DB.pageSize;
  const total = Math.ceil(filtered.length / size);
  const paged = filtered.slice((page-1)*size, page*size);
 
  document.getElementById('productsTbody').innerHTML = paged.length ? paged.map(p => {
    const status = p.qty === 0 ? 'Out of Stock' : p.qty <= 10 ? 'Low Stock' : 'In Stock';
    const badgeClass = p.qty === 0 ? 'badge-danger' : p.qty <= 10 ? 'badge-warning' : 'badge-success';
    return `<tr>
      <td><code style="background:var(--bg-secondary);padding:3px 8px;border-radius:6px;font-size:12px">${p.sku}</code></td>
      <td><strong>${p.name}</strong><br><small style="color:var(--text-muted)">${p.desc.substring(0,40)}...</small></td>
      <td><span class="badge badge-info">${p.category}</span></td>
      <td><strong>$${p.price.toFixed(2)}</strong></td>
      <td>
        <div style="display:flex;align-items:center;gap:10px">
          <span style="font-weight:600">${p.qty}</span>
          <div style="flex:1;height:4px;background:var(--border);border-radius:2px;max-width:80px">
            <div style="height:100%;width:${Math.min(100,p.qty/2)}%;background:${p.qty===0?'var(--danger)':p.qty<=10?'var(--warning)':'var(--success)'};border-radius:2px"></div>
          </div>
        </div>
      </td>
      <td>${p.supplier}</td>
      <td><span class="badge ${badgeClass}">${status}</span></td>
      <td>
        <div class="actions">
          <button class="btn-icon edit" onclick="editProduct(${p.id})" title="Edit"><i class="fas fa-pen"></i></button>
          <button class="btn-icon del" onclick="deleteProduct(${p.id})" title="Delete"><i class="fas fa-trash"></i></button>
        </div>
      </td>
    </tr>`;
  }).join('') : '<tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted)">No products found</td></tr>';
 
  const totalVal = DB.products.reduce((sum,p) => sum + p.price * p.qty, 0);
  document.getElementById('invTotal').textContent = DB.products.length;
  document.getElementById('invLow').textContent = DB.products.filter(p => p.qty > 0 && p.qty <= 10).length;
  document.getElementById('invOut').textContent = DB.products.filter(p => p.qty === 0).length;
  document.getElementById('invValue').textContent = '$'+totalVal.toLocaleString('en-US',{maximumFractionDigits:0});
 
  // populate category filter
  const catFilter = document.getElementById('catFilter');
  catFilter.innerHTML = '<option value="">All Categories</option>' + DB.categories.map(c => `<option value="${c}" ${DB.filters.category===c?'selected':''}>${c}</option>`).join('');
  renderPagination('prodPagination', page, total, 'products');
}
 
function filterProducts(val) { DB.filters.products = val; DB.currentPage.products = 1; renderInventory(); }
function filterByCategory(val) { DB.filters.category = val; DB.currentPage.products = 1; renderInventory(); }
 
function saveProduct() {
  const name = document.getElementById('pName').value.trim();
  const sku = document.getElementById('pSku').value.trim();
  const price = parseFloat(document.getElementById('pPrice').value);
  const qty = parseInt(document.getElementById('pQty').value);
  if (!name || !sku || isNaN(price) || isNaN(qty)) { showToast('Please fill all required fields','error'); return; }
  DB.products.push({ id: DB.nextProductId++, name, sku, category: document.getElementById('pCategory').value, price, qty, supplier: document.getElementById('pSupplier').value, desc: document.getElementById('pDesc').value });
  closeModal(); renderInventory(); renderAlerts(); populateSaleDropdowns();
  showToast(`Product "${name}" added!`, 'success');
}
 
function editProduct(id) {
  const p = DB.products.find(x => x.id === id);
  if (!p) return;
  document.getElementById('editPId').value = id;
  document.getElementById('editPName').value = p.name;
  document.getElementById('editPSku').value = p.sku;
  document.getElementById('editPCategory').value = p.category;
  document.getElementById('editPPrice').value = p.price;
  document.getElementById('editPQty').value = p.qty;
  document.getElementById('editPSupplier').value = p.supplier;
  document.getElementById('editPDesc').value = p.desc;
  openModal('editProduct');
}
 
function updateProduct() {
  const id = parseInt(document.getElementById('editPId').value);
  const p = DB.products.find(x => x.id === id);
  if (!p) return;
  p.name = document.getElementById('editPName').value;
  p.sku = document.getElementById('editPSku').value;
  p.category = document.getElementById('editPCategory').value;
  p.price = parseFloat(document.getElementById('editPPrice').value);
  p.qty = parseInt(document.getElementById('editPQty').value);
  p.supplier = document.getElementById('editPSupplier').value;
  p.desc = document.getElementById('editPDesc').value;
  closeModal(); renderInventory(); renderAlerts(); populateSaleDropdowns();
  showToast('Product updated!', 'success');
}
 
function deleteProduct(id) {
  const p = DB.products.find(x => x.id === id);
  if (!p) return;
  if (confirm(`Delete product "${p.name}"?`)) {
    DB.products = DB.products.filter(x => x.id !== id);
    renderInventory(); renderAlerts(); populateSaleDropdowns();
    showToast('Product deleted.', 'warning');
  }
}
 
// =================== SALES ===================
function initSales() {
  populateSaleDropdowns();
  renderCartUI();
  renderSalesHistory();
}
 
function populateSaleDropdowns() {
  const custSel = document.getElementById('saleCustomer');
  const prodSel = document.getElementById('saleProduct');
  if (!custSel || !prodSel) return;
  custSel.innerHTML = '<option value="">— Select Customer —</option>' + DB.customers.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
  prodSel.innerHTML = '<option value="">— Select Product —</option>' + DB.products.filter(p=>p.qty>0).map(p => `<option value="${p.id}">${p.name} ($${p.price.toFixed(2)}) — ${p.qty} in stock</option>`).join('');
}
 
function addToCart() {
  const pid = parseInt(document.getElementById('saleProduct').value);
  const qty = parseInt(document.getElementById('saleQty').value) || 1;
  if (!pid) { showToast('Please select a product','error'); return; }
  const prod = DB.products.find(p => p.id === pid);
  if (!prod) return;
  if (qty > prod.qty) { showToast(`Only ${prod.qty} in stock!`,'error'); return; }
  const existing = DB.cart.find(i => i.productId === pid);
  if (existing) {
    if (existing.qty + qty > prod.qty) { showToast('Exceeds available stock','error'); return; }
    existing.qty += qty;
  } else {
    DB.cart.push({ productId: pid, name: prod.name, qty, price: prod.price });
  }
  document.getElementById('saleProduct').value = '';
  document.getElementById('saleQty').value = 1;
  renderCartUI(); calcTotals();
}
 
function removeFromCart(idx) {
  DB.cart.splice(idx, 1);
  renderCartUI(); calcTotals();
}
 
function changeCartQty(idx, delta) {
  const item = DB.cart[idx];
  const prod = DB.products.find(p => p.id === item.productId);
  const newQty = item.qty + delta;
  if (newQty < 1) { removeFromCart(idx); return; }
  if (prod && newQty > prod.qty) { showToast('Exceeds available stock','error'); return; }
  item.qty = newQty;
  renderCartUI(); calcTotals();
}
 
function renderCartUI() {
  const tbody = document.getElementById('cartBody');
  const empty = document.getElementById('cartEmpty');
  if (DB.cart.length === 0) { tbody.innerHTML = ''; empty.style.display = 'flex'; return; }
  empty.style.display = 'none';
  tbody.innerHTML = DB.cart.map((item, i) => `
    <tr>
      <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${item.name}</td>
      <td>
        <div style="display:flex;align-items:center;gap:6px">
          <button class="btn-icon" style="background:var(--glass);width:24px;height:24px" onclick="changeCartQty(${i},-1)"><i class="fas fa-minus" style="font-size:10px"></i></button>
          <span style="width:24px;text-align:center;font-weight:600">${item.qty}</span>
          <button class="btn-icon" style="background:var(--glass);width:24px;height:24px" onclick="changeCartQty(${i},1)"><i class="fas fa-plus" style="font-size:10px"></i></button>
        </div>
      </td>
      <td>$${item.price.toFixed(2)}</td>
      <td><strong>$${(item.qty * item.price).toFixed(2)}</strong></td>
      <td><button class="btn-icon del" onclick="removeFromCart(${i})"><i class="fas fa-times"></i></button></td>
    </tr>`).join('');
}
 
function calcTotals() {
  const subtotal = DB.cart.reduce((s, i) => s + i.qty * i.price, 0);
  const discount = parseFloat(document.getElementById('discountInput').value) || 0;
  const discounted = subtotal * (1 - discount/100);
  const tax = discounted * 0.15;
  const grand = discounted + tax;
  document.getElementById('subtotal').textContent = '$'+subtotal.toFixed(2);
  document.getElementById('taxAmount').textContent = '$'+tax.toFixed(2);
  document.getElementById('grandTotal').textContent = '$'+grand.toFixed(2);
}
 
function clearCart() { DB.cart = []; renderCartUI(); calcTotals(); }
 
function selectPayment(el, method) {
  document.querySelectorAll('.pay-opt').forEach(o => o.classList.remove('active'));
  el.classList.add('active');
}
 
function completeSale() {
  if (DB.cart.length === 0) { showToast('Cart is empty','error'); return; }
  const custId = parseInt(document.getElementById('saleCustomer').value);
  if (!custId) { showToast('Please select a customer','error'); return; }
  const customer = DB.customers.find(c => c.id === custId);
  const subtotal = DB.cart.reduce((s, i) => s + i.qty * i.price, 0);
  const discount = parseFloat(document.getElementById('discountInput').value) || 0;
  const discounted = subtotal * (1-discount/100);
  const tax = discounted * 0.15;
  const grand = discounted + tax;
  const method = document.querySelector('.pay-opt.active input') ? document.querySelector('.pay-opt.active input').value : 'cash';
  const invoice = 'INV-' + String(DB.nextInvoiceNum++).padStart(4,'0');
 
  // Deduct stock
  DB.cart.forEach(item => {
    const prod = DB.products.find(p => p.id === item.productId);
    if (prod) prod.qty -= item.qty;
  });
 
  const sale = {
    id: DB.nextSaleId++,
    invoice,
    customerId: custId,
    customerName: customer.name,
    items: [...DB.cart],
    subtotal,
    discount,
    tax,
    total: grand,
    method,
    notes: document.getElementById('saleNotes').value,
    date: new Date().toISOString().split('T')[0]
  };
  DB.sales.push(sale);
  if (customer) customer.purchases++;
 
  showInvoice(sale, customer);
  clearCart();
  document.getElementById('saleCustomer').value = '';
  document.getElementById('discountInput').value = 0;
  document.getElementById('saleNotes').value = '';
  calcTotals();
  renderSalesHistory();
  renderAlerts();
  populateSaleDropdowns();
  showToast(`Sale ${invoice} completed — $${grand.toFixed(2)}`,'success');
}
 
function showInvoice(sale, customer) {
  const html = `
    <div class="invoice-preview">
      <div class="inv-header">
        <div class="inv-logo">
          <div class="inv-logo-icon"><i class="fas fa-store"></i></div>
          <div class="inv-logo-text"><h2>SmartBiz</h2><p>Retail Management System</p></div>
        </div>
        <div class="inv-meta">
          <h3>INVOICE</h3>
          <p>${sale.invoice}</p>
          <p>${sale.date}</p>
        </div>
      </div>
      <div class="inv-parties">
        <div class="inv-party">
          <h4>From</h4>
          <p>SmartBiz Retail Co.</p>
          <small>123 Business Ave, Tech City</small><br>
          <small>admin@smartbiz.com</small>
        </div>
        <div class="inv-party" style="text-align:right">
          <h4>Bill To</h4>
          <p>${customer.name}</p>
          <small>${customer.email}</small><br>
          <small>${customer.phone}</small>
        </div>
      </div>
      <table class="data-table">
        <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr></thead>
        <tbody>${sale.items.map(i=>`<tr><td>${i.name}</td><td>${i.qty}</td><td>$${i.price.toFixed(2)}</td><td>$${(i.qty*i.price).toFixed(2)}</td></tr>`).join('')}</tbody>
      </table>
      <div class="inv-totals-box">
        <div class="inv-total-row"><span>Subtotal</span><span>$${sale.subtotal.toFixed(2)}</span></div>
        ${sale.discount ? `<div class="inv-total-row"><span>Discount (${sale.discount}%)</span><span style="color:var(--success)">-$${(sale.subtotal*sale.discount/100).toFixed(2)}</span></div>` : ''}
        <div class="inv-total-row"><span>Tax (15%)</span><span>$${sale.tax.toFixed(2)}</span></div>
        <div class="inv-total-row grand"><span>Grand Total</span><span>$${sale.total.toFixed(2)}</span></div>
      </div>
      <div class="inv-footer">
        <p>Payment Method: <strong>${sale.method.toUpperCase()}</strong></p>
        ${sale.notes ? `<p>Notes: ${sale.notes}</p>` : ''}
        <p style="margin-top:12px">Thank you for your business!</p>
      </div>
    </div>`;
  document.getElementById('invoicePreview').innerHTML = html;
  openModal('invoice');
}
 
function renderSalesHistory() {
  const tbody = document.getElementById('salesHistoryBody');
  if (!tbody) return;
  const filter = DB.filters.sales || '';
  const filtered = DB.sales.filter(s => s.invoice.toLowerCase().includes(filter) || s.customerName.toLowerCase().includes(filter)).slice().reverse();
  tbody.innerHTML = filtered.length ? filtered.map(s => `
    <tr>
      <td><span style="color:var(--accent);font-weight:600">${s.invoice}</span></td>
      <td>${s.customerName}</td>
      <td><strong>$${s.total.toFixed(2)}</strong></td>
      <td><span class="badge ${s.method==='card'?'badge-info':s.method==='cash'?'badge-success':'badge-warning'}">${s.method}</span></td>
      <td>${s.date}</td>
      <td><button class="btn-icon view" onclick="viewSale(${s.id})"><i class="fas fa-eye"></i></button></td>
    </tr>`).join('') : '<tr><td colspan="6" style="text-align:center;padding:20px;color:var(--text-muted)">No sales found</td></tr>';
}
 
function viewSale(id) {
  const sale = DB.sales.find(s => s.id === id);
  const customer = DB.customers.find(c => c.id === sale.customerId) || { name: sale.customerName, email: '', phone: '' };
  showInvoice(sale, customer);
}
 
function filterSales(val) { DB.filters.sales = val; renderSalesHistory(); }
 
// =================== REPORTS ===================
let reportChart = null;
function showReport(type) {
  document.getElementById('reportViewer').style.display = 'block';
  document.getElementById('reportViewer').scrollIntoView({ behavior: 'smooth' });
  const titles = { sales: 'Sales Report', inventory: 'Inventory Report', revenue: 'Revenue Report', customers: 'Customer Report' };
  document.getElementById('reportTitle').textContent = titles[type] || 'Report';
 
  const today = new Date().toISOString().split('T')[0];
  const monthAgo = new Date(Date.now() - 30*24*60*60*1000).toISOString().split('T')[0];
  document.getElementById('reportFrom').value = monthAgo;
  document.getElementById('reportTo').value = today;
 
  if (type === 'sales') generateSalesReport();
  else if (type === 'inventory') generateInventoryReport();
  else if (type === 'revenue') generateRevenueReport();
  else if (type === 'customers') generateCustomerReport();
}
 
function generateSalesReport() {
  const totalSales = DB.sales.length;
  const totalRev = DB.sales.reduce((s,x) => s+x.total, 0);
  const avgOrder = totalRev / (totalSales || 1);
  document.getElementById('reportStats').innerHTML = `
    <div class="report-stat"><div class="val">${totalSales}</div><div class="lbl">Total Sales</div></div>
    <div class="report-stat"><div class="val">$${totalRev.toFixed(0)}</div><div class="lbl">Total Revenue</div></div>
    <div class="report-stat"><div class="val">$${avgOrder.toFixed(2)}</div><div class="lbl">Avg Order Value</div></div>
    <div class="report-stat"><div class="val">${DB.sales.filter(s=>s.method==='card').length}</div><div class="lbl">Card Payments</div></div>`;
  document.getElementById('reportThead').innerHTML = '<tr><th>Invoice</th><th>Customer</th><th>Items</th><th>Subtotal</th><th>Discount</th><th>Tax</th><th>Total</th><th>Method</th><th>Date</th></tr>';
  document.getElementById('reportTbody').innerHTML = DB.sales.slice().reverse().map(s => `
    <tr>
      <td style="color:var(--accent)">${s.invoice}</td>
      <td>${s.customerName}</td>
      <td>${s.items.length}</td>
      <td>$${s.subtotal.toFixed(2)}</td>
      <td>${s.discount}%</td>
      <td>$${s.tax.toFixed(2)}</td>
      <td><strong>$${s.total.toFixed(2)}</strong></td>
      <td><span class="badge ${s.method==='card'?'badge-info':s.method==='cash'?'badge-success':'badge-warning'}">${s.method}</span></td>
      <td>${s.date}</td>
    </tr>`).join('');
  renderReportChart('bar', ['INV-0038','INV-0039','INV-0040','INV-0041','INV-0042'], DB.sales.map(s=>s.total), 'Sales Totals ($)');
}
 
function generateInventoryReport() {
  const totalProducts = DB.products.length;
  const totalValue = DB.products.reduce((s,p) => s+p.price*p.qty, 0);
  const lowStock = DB.products.filter(p=>p.qty>0&&p.qty<=10).length;
  const outOfStock = DB.products.filter(p=>p.qty===0).length;
  document.getElementById('reportStats').innerHTML = `
    <div class="report-stat"><div class="val">${totalProducts}</div><div class="lbl">Total Products</div></div>
    <div class="report-stat"><div class="val">$${totalValue.toLocaleString()}</div><div class="lbl">Inventory Value</div></div>
    <div class="report-stat"><div class="val">${lowStock}</div><div class="lbl">Low Stock</div></div>
    <div class="report-stat"><div class="val">${outOfStock}</div><div class="lbl">Out of Stock</div></div>`;
  document.getElementById('reportThead').innerHTML = '<tr><th>SKU</th><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Value</th><th>Status</th></tr>';
  document.getElementById('reportTbody').innerHTML = DB.products.map(p => {
    const status = p.qty===0?'Out of Stock':p.qty<=10?'Low Stock':'In Stock';
    const badge = p.qty===0?'badge-danger':p.qty<=10?'badge-warning':'badge-success';
    return `<tr><td><code style="background:var(--bg-secondary);padding:2px 6px;border-radius:4px;font-size:12px">${p.sku}</code></td><td><strong>${p.name}</strong></td><td>${p.category}</td><td>$${p.price.toFixed(2)}</td><td>${p.qty}</td><td>$${(p.price*p.qty).toFixed(2)}</td><td><span class="badge ${badge}">${status}</span></td></tr>`;
  }).join('');
  renderReportChart('bar', DB.products.map(p=>p.name.split(' ').slice(0,2).join(' ')), DB.products.map(p=>p.qty), 'Stock Quantities');
}
 
function generateRevenueReport() {
  const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const data = [42000,38000,51000,47000,63000,58000,72000,68000,75000,81000,77000,84320];
  const total = data.reduce((a,b)=>a+b,0);
  document.getElementById('reportStats').innerHTML = `
    <div class="report-stat"><div class="val">$${total.toLocaleString()}</div><div class="lbl">Annual Revenue</div></div>
    <div class="report-stat"><div class="val">$${(total/12).toFixed(0)}</div><div class="lbl">Avg Monthly</div></div>
    <div class="report-stat"><div class="val">$84,320</div><div class="lbl">Best Month (Dec)</div></div>
    <div class="report-stat"><div class="val">+18.3%</div><div class="lbl">Growth Rate</div></div>`;
  document.getElementById('reportThead').innerHTML = '<tr><th>Month</th><th>Revenue</th><th>Growth</th><th>Transactions</th></tr>';
  document.getElementById('reportTbody').innerHTML = months.map((m,i) => `
    <tr><td>${m} 2025</td><td><strong>$${data[i].toLocaleString()}</strong></td><td style="color:${i>0&&data[i]>data[i-1]?'var(--success)':'var(--danger)'}">${i>0?((data[i]-data[i-1])/data[i-1]*100).toFixed(1)+'%':'—'}</td><td>${Math.floor(data[i]/350)}</td></tr>`).join('');
  renderReportChart('line', months, data, 'Monthly Revenue ($)');
}
 
function generateCustomerReport() {
  const total = DB.customers.length;
  const totalPurchases = DB.customers.reduce((s,c)=>s+c.purchases,0);
  const avg = totalPurchases / (total||1);
  document.getElementById('reportStats').innerHTML = `
    <div class="report-stat"><div class="val">${total}</div><div class="lbl">Total Customers</div></div>
    <div class="report-stat"><div class="val">${totalPurchases}</div><div class="lbl">Total Purchases</div></div>
    <div class="report-stat"><div class="val">${avg.toFixed(1)}</div><div class="lbl">Avg Purchases</div></div>
    <div class="report-stat"><div class="val">31</div><div class="lbl">Top Customer Orders</div></div>`;
  document.getElementById('reportThead').innerHTML = '<tr><th>Name</th><th>Email</th><th>Phone</th><th>Purchases</th><th>Registered</th></tr>';
  document.getElementById('reportTbody').innerHTML = DB.customers.sort((a,b)=>b.purchases-a.purchases).map(c=>`<tr><td><strong>${c.name}</strong></td><td>${c.email}</td><td>${c.phone}</td><td><span class="badge badge-info">${c.purchases} orders</span></td><td>${c.registered}</td></tr>`).join('');
  renderReportChart('bar', DB.customers.map(c=>c.name.split(' ')[0]), DB.customers.map(c=>c.purchases), 'Customer Purchases');
}
 
function renderReportChart(type, labels, data, label) {
  const ctx = document.getElementById('reportChart');
  if (!ctx) return;
  if (reportChart) reportChart.destroy();
  reportChart = new Chart(ctx, {
    type,
    data: {
      labels,
      datasets: [{ label, data, backgroundColor: type==='line'?'rgba(99,102,241,.1)':labels.map((_,i)=>`hsla(${240+i*30},70%,65%,.7)`), borderColor: '#6366f1', borderWidth: 2, tension: 0.4, fill: type==='line' }]
    },
    options: { responsive:true, plugins:{legend:{display:false}}, scales:{x:{grid:{color:'rgba(255,255,255,.04)'},ticks:{color:'#5a5e7a'}},y:{grid:{color:'rgba(255,255,255,.04)'},ticks:{color:'#5a5e7a'}}} }
  });
}
 
function filterReport() { showToast('Report filtered for selected date range','info'); }
function exportPDF() { showToast('Exporting PDF... (feature available in full Laravel version)','info'); }
function exportExcel() { showToast('Exporting Excel... (feature available in full Laravel version)','info'); }
 
// =================== SETTINGS ===================
function switchSettings(el, panel) {
  document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
  document.getElementById(`settings-${panel}`).classList.add('active');
}
 
function saveProfile() {
  const name = document.getElementById('profileName').value;
  if (DB.currentUser) {
    DB.currentUser.name = name;
    DB.currentUser.avatar = name.charAt(0).toUpperCase();
    document.getElementById('sidebarAvatar').textContent = DB.currentUser.avatar;
    document.getElementById('topbarAvatar').textContent = DB.currentUser.avatar;
    document.getElementById('sidebarName').textContent = name;
    document.getElementById('topbarName').textContent = name;
    document.getElementById('avatarPreview').textContent = DB.currentUser.avatar;
  }
  showToast('Profile updated successfully!', 'success');
}
 
function previewAvatar(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      const prev = document.getElementById('avatarPreview');
      prev.innerHTML = `<img src="${e.target.result}" alt="avatar">`;
    };
    reader.readAsDataURL(input.files[0]);
  }
}
 
function checkPassStrength(val) {
  const bar = document.getElementById('passBar');
  const lbl = document.getElementById('passLabel');
  if (!val) { bar.style.width='0'; bar.style.background='var(--danger)'; lbl.textContent='Enter a password'; return; }
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const levels = [{w:'25%',c:'var(--danger)',l:'Weak'},{w:'50%',c:'var(--warning)',l:'Fair'},{w:'75%',c:'#a3e635',l:'Good'},{w:'100%',c:'var(--success)',l:'Strong'}];
  const lvl = levels[score-1] || levels[0];
  bar.style.width = lvl.w;
  bar.style.background = lvl.c;
  lbl.textContent = lvl.l;
}
 
// =================== MODALS ===================
function openModal(name) {
  document.getElementById('modalOverlay').classList.add('show');
  document.getElementById(`modal-${name}`).classList.add('show');
}
function closeModal() {
  document.getElementById('modalOverlay').classList.remove('show');
  document.querySelectorAll('.modal').forEach(m => m.classList.remove('show'));
}
 
// =================== PAGINATION ===================
function renderPagination(containerId, current, total, type) {
  const container = document.getElementById(containerId);
  if (!container) return;
  if (total <= 1) { container.innerHTML = ''; return; }
  let html = '';
  if (current > 1) html += `<div class="page-btn" onclick="goPage('${type}',${current-1})"><i class="fas fa-chevron-left" style="font-size:11px"></i></div>`;
  for (let i = 1; i <= total; i++) {
    html += `<div class="page-btn ${i===current?'active':''}" onclick="goPage('${type}',${i})">${i}</div>`;
  }
  if (current < total) html += `<div class="page-btn" onclick="goPage('${type}',${current+1})"><i class="fas fa-chevron-right" style="font-size:11px"></i></div>`;
  container.innerHTML = html;
}
function goPage(type, page) {
  DB.currentPage[type] = page;
  if (type === 'customers') renderCustomers();
  if (type === 'products') renderInventory();
}
 
// =================== UI HELPERS ===================
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const main = document.getElementById('mainContent');
  if (window.innerWidth <= 900) {
    sidebar.classList.toggle('mobile-open');
  } else {
    DB.sidebarCollapsed = !DB.sidebarCollapsed;
    sidebar.classList.toggle('collapsed', DB.sidebarCollapsed);
    main.classList.toggle('expanded', DB.sidebarCollapsed);
  }
}
 
function toggleTheme() {
  const html = document.documentElement;
  const isDark = html.getAttribute('data-theme') === 'dark';
  html.setAttribute('data-theme', isDark ? 'light' : 'dark');
  document.getElementById('themeIcon').className = isDark ? 'fas fa-sun' : 'fas fa-moon';
  showToast(`Switched to ${isDark ? 'light' : 'dark'} mode`, 'info');
}
 
function toggleNotifications() {
  const dd = document.getElementById('notifDropdown');
  dd.classList.toggle('show');
  document.getElementById('userDropdown').classList.remove('show');
}
 
function toggleUserMenu() {
  const dd = document.getElementById('userDropdown');
  dd.classList.toggle('show');
  document.getElementById('notifDropdown').classList.remove('show');
}
 
function markAllRead() {
  document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
  document.querySelector('.notif-count').style.display = 'none';
  showToast('All notifications marked as read','success');
}
 
function closeAllDropdowns() {
  document.querySelectorAll('.notif-dropdown,.user-dropdown').forEach(d => d.classList.remove('show'));
}
 
function globalSearch() {
  const q = document.getElementById('globalSearch').value.toLowerCase();
  if (!q) return;
  const custMatch = DB.customers.filter(c => c.name.toLowerCase().includes(q) || c.email.toLowerCase().includes(q));
  const prodMatch = DB.products.filter(p => p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q));
  if (custMatch.length) { navigate('customers', document.querySelector('.nav-item:nth-child(5)')); DB.filters.customers = q; renderCustomers(); }
  else if (prodMatch.length) { navigate('inventory', document.querySelector('.nav-item:nth-child(6)')); DB.filters.products = q; renderInventory(); }
}
 
// =================== TOAST ===================
function showToast(message, type = 'info') {
  const icons = { success: 'fa-check-circle', error: 'fa-times-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle' };
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `<i class="fas ${icons[type]}"></i><span>${message}</span><button class="toast-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>`;
  document.getElementById('toastContainer').appendChild(toast);
  setTimeout(() => { toast.classList.add('removing'); setTimeout(() => toast.remove(), 300); }, 3500);
}
 
// =================== GLOBAL EVENT LISTENERS ===================
document.addEventListener('click', (e) => {
  if (!e.target.closest('.notif-wrap')) document.getElementById('notifDropdown').classList.remove('show');
  if (!e.target.closest('.user-menu')) document.getElementById('userDropdown').classList.remove('show');
});
 
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') { closeModal(); closeAllDropdowns(); }
  if (e.key === 'Enter' && document.getElementById('loginScreen') && !document.getElementById('loginScreen').classList.contains('hidden')) doLogin();
});
 
// =================== READY ===================
document.addEventListener('DOMContentLoaded', () => {
  // Date range defaults for reports
  const today = new Date().toISOString().split('T')[0];
  const monthAgo = new Date(Date.now() - 30*24*60*60*1000).toISOString().split('T')[0];
  if (document.getElementById('reportFrom')) {
    document.getElementById('reportFrom').value = monthAgo;
    document.getElementById('reportTo').value = today;
  }
  console.log('%cSmartBiz Retail Management System', 'font-size:18px;color:#6366f1;font-weight:bold');
  console.log('%cVersion 2.4.1 | Built with ❤️', 'color:#8b5cf6');
});