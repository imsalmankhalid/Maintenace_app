var gvjs_XY="gantt.barCornerRadius",gvjs_YY="hAxis.position";function gvjs_ZY(){this.xy=null}gvjs_o(gvjs_ZY,gvjs_Cl);gvjs_ZY.prototype.Pb=function(a){return!!gvjs__Y(this,a)};gvjs_ZY.prototype.Ac=function(a){a=gvjs__Y(this,a);if(null!=a)return a;throw Error(this.xy);};
function gvjs__Y(a,b){b=gvjs_Dl(b);var c=new gvjs_$Q(0),d=new gvjs_$Q(1),e=new gvjs_$Q(2),f=0;gvjs_Gl(b,e.index(),gvjs_l)||(f=-1,e=null);var g=new gvjs_$Q(3+f),h=new gvjs_$Q(4+f),k=new gvjs_$Q(5+f),l=new gvjs_$Q(6+f);f=new gvjs_$Q(7+f);return a.jb(b,c.index(),gvjs_l)&&a.jb(b,d.index(),gvjs_l)&&a.jb(b,g.index(),gvjs_Lb)&&a.jb(b,h.index(),gvjs_Lb)&&a.jb(b,k.index(),gvjs_g)&&a.jb(b,l.index(),gvjs_g)&&a.jb(b,f.index(),gvjs_l)?{zra:c,qw:d,vL:g,WH:h,nna:k,Rua:l,Lma:f,Qea:e}:null}
gvjs_ZY.prototype.jb=function(a,b,c){return gvjs_Gl(a,b,c)?!0:(this.xy=gvjs_Sa+b+gvjs_ba+c+"'.",!1)};
var gvjs_0Y={50:"#FAFAFA",100:"#F5F5F5",200:"#EEEEEE",300:"#E0E0E0",400:"#BDBDBD",500:"#9E9E9E",600:gvjs_qr,700:"#616161",800:"#424242",900:"#212121"},gvjs_$ka=[{color:gvjs_SF[gvjs_Sr],dark:gvjs_SF[gvjs_Vr],light:gvjs_SF[gvjs_Or]},{color:gvjs_TF[gvjs_Sr],dark:gvjs_TF[gvjs_Wr],light:gvjs_TF[gvjs_Or]},{color:gvjs_UF[gvjs_Tr],dark:gvjs_UF[gvjs_Vr],light:gvjs_UF[gvjs_Or]},{color:gvjs_VF[gvjs_Sr],dark:gvjs_VF[gvjs_Ur],light:gvjs_VF[gvjs_Or]},{color:gvjs_WF[gvjs_Rr],dark:gvjs_WF[gvjs_Vr],light:gvjs_WF[gvjs_Or]},
{color:gvjs_XF[gvjs_Tr],dark:gvjs_XF[gvjs_Vr],light:gvjs_XF[gvjs_Or]},{color:gvjs_YF[gvjs_Rr],dark:gvjs_YF[gvjs_Ur],light:gvjs_YF[gvjs_Or]},{color:gvjs_ZF[gvjs_Vr],dark:gvjs_ZF[gvjs_Wr],light:gvjs_ZF[gvjs_Or]},{color:gvjs__F[gvjs_Rr],dark:gvjs__F[gvjs_Tr],light:gvjs__F[gvjs_Or]},{color:gvjs_0F["300"],dark:gvjs_0F[gvjs_Sr],light:gvjs_0F[gvjs_Or]},{color:gvjs_1F[gvjs_Ur],dark:gvjs_1F[gvjs_Wr],light:gvjs_1F[gvjs_Or]},{color:gvjs_0F[gvjs_Ur],dark:gvjs_0F[gvjs_Wr],light:gvjs_0F["200"]}];
function gvjs_1Y(a){this.u1=0;this.oh=a.fa("gantt.palette",gvjs_$ka);this.qa=new Map}gvjs_1Y.prototype.Sz=function(a){var b=this.oh[a];if(gvjs_r(b))a=b;else{var c=this.oh;var d=gvjs_vj(b);d=gvjs_uj(gvjs_1z(d,.15));var e=gvjs_vj(b);e=gvjs_uj(gvjs_2z(e,.07));a=c[a]={color:b,dark:d,light:e}}return a};gvjs_1Y.prototype.color=function(a){return this.Sz(a).color};gvjs_1Y.prototype.qb=function(a){return this.Sz(a).dark};gvjs_1Y.prototype.jh=function(a){return this.Sz(a).light};function gvjs_2Y(a,b,c,d,e,f,g,h,k){this.ac=b;this.Ei=c;this.Xd=d;this.yf=e;this.Nk=f;this.dea=g;this.Mma=h||[];this.NA=[];this.Vw=[];this.zn=this.error=null;this.yi=a;this.qH=!1;this.Rea=null!=k?k:"";this.UB=0}gvjs_2Y.prototype.getId=function(){return this.ac};gvjs_2Y.prototype.setStart=function(a){this.Xd=a};gvjs_2Y.prototype.getName=function(){return this.Ei};gvjs_2Y.prototype.nP=function(){return this.Mma};
function gvjs_ala(a){var b=gvjs_Ee(a.NA,function(c,d){return null===c?d.yf:Math.max(c,d.yf)},null);if(null===b)throw Error("Cannot compute start time from dependencies for task: "+a.ac);a.Xd=new Date(b);a.yf=new Date(a.Xd.getTime()+a.Nk)};function gvjs_3Y(){this.T4=new Map}gvjs_3Y.prototype.sB=function(a){this.T4.set(a.getId(),a)};gvjs_3Y.prototype.sort=function(a){var b=gvjs_4Y(this),c=gvjs_5Y(b);gvjs_6Y(c,a);gvjs_7Y(c);for(a=0;a<b.length;a++)gvjs_Qe(b[a].NA,gvjs_8Y);c=gvjs_bla(c);if(c.length!=b.length)throw Error("Cycle detected.");return c};function gvjs_6Y(a,b){if(null!=b)for(var c=0;c<a.length;c++){var d=a[c];null==d.Xd&&d.setStart(b)}}
function gvjs_4Y(a){for(var b=[].concat(gvjs_9d(a.T4.values())),c=0;c<b.length;c++)for(var d=b[c],e=d.nP(),f=0;f<e.length;f++){var g=e[f],h=a.T4.get(g);if(null==h)throw"Missing dependency '"+g+" in task ${task.getId()}.";d.NA.push(h);h.Vw.push(d)}return b}function gvjs_5Y(a){return a.filter(function(b){return 0==b.NA.length})}
function gvjs_7Y(a){for(var b=new gvjs_Yk,c=new Set,d=0;d<a.length;d++){var e=a[d];b.enqueue(e);c.add(e)}for(;!b.isEmpty();){a=gvjs_Ux(b);d=a.Vw;for(e=0;e<d.length;e++){var f=d[e];if(!c.has(f)){for(var g=!0,h=f.NA,k=0;k<h.length;k++){var l=h[k];if(l!=a){var m=null!=l.Xd,n=null!=l.yf;null!=l.Nk&&m&&n||(g=!1)}}g&&(c.add(f),b.enqueue(f))}}d=null!=a.Xd;e=null!=a.yf;f=null!=a.Nk;if(!f||d||e)if(d&&e)f?a.Nk!=a.yf.getTime()-a.Xd.getTime()&&(a.error="Duration not equal to end time minus start time."):a.Nk=
a.yf.getTime()-a.Xd.getTime();else if(d)if(f)a.yf=new Date(a.Xd.getTime()+a.Nk);else throw Error("Missing duration or end time for task: "+a.ac);else if(e)if(f)a.Xd=new Date(a.yf.getTime()-a.Nk);else throw Error("Missing duration or start time for task: "+a.ac);else throw Error("Cannot compute start/end times for task: "+a.ac);else gvjs_ala(a)}}function gvjs_8Y(a,b){var c=a.Xd,d=b.Xd;if(c<d)return-1;if(c>d)return 1;a=a.Vw.length;b=b.Vw.length;return a<b?-1:a>b?1:0}
function gvjs_bla(a){function b(f,g){var h=g.NA.every(function(k){return d.has(k)});if((null===f||h)&&!d.has(g))for(c.push(g),d.add(g),f=g.Vw,h=0;h<f.length;h++)b(g,f[h])}var c=[],d=new Set;gvjs_Qe(a,gvjs_8Y);for(var e=0;e<a.length;e++)b(null,a[e]);return c};var gvjs_9Y={start:0,center:.5,end:1};function gvjs_$Y(a,b,c,d){if(null==a)throw Error(gvjs_ns);this.Z=a;this.Xe=(new gvjs_ZY).Ac(a);this.m=b;this.eb=d;this.Ww=c;this.cH=new gvjs_1Y(b);this.PB=0}
gvjs_$Y.prototype.$g=function(){for(var a=this.Z,b=a.ca(),c=[],d=0;d<b;++d)c.push(gvjs_cla(this,a,d));b=gvjs_dla(c);a=gvjs_L(this.m,"gantt.defaultStartDate",Date.now());a=new Date(a);gvjs_K(this.m,"gantt.sortTasks",!0)?a=b.sort(a):(b=gvjs_4Y(b),d=gvjs_5Y(b),gvjs_6Y(d,a),gvjs_7Y(d),a=b);b=a;d=gvjs_ry(this.m,"gantt.labelStyle");var e=gvjs_L(this.m,"gantt.labelMargin",16),f=gvjs_ela(this,b,d,e),g=gvjs_fla(b);a=new gvjs_1S(this.eb.width-f,g.min,g.max,f,0,0);var h=g.max;if(gvjs_K(this.m,"gantt.criticalPathEnabled",
!0))for(g=[],gvjs_aZ(g,b,h);0<g.length;)h=g.shift(),gvjs_aZ(g,h.NA,h.Xd);var k=gvjs_L(this.m,"gantt.barHeight",d.fontSize+12),l=gvjs_L(this.m,"gantt.trackHeight",k+16);g={rect:new gvjs_5(0,0,this.eb.width,this.eb.height),options:gvjs_bZ(this.m,gvjs_ht)};gvjs_vx===gvjs_J(this.m,gvjs_YY,gvjs_vt)?this.PB=l:this.PB=0;h=this.Z.ca();for(var m=this.eb.width,n=[],p=[],q=gvjs_cZ(gvjs_bZ(this.m,"gantt.innerGridTrack"),gvjs_np,gvjs_oy(this.m,gvjs_it,gvjs_ea)),r=gvjs_cZ(gvjs_bZ(this.m,"gantt.innerGridDarkTrack"),
gvjs_np,gvjs_uj(gvjs_1z(gvjs_vj(q.fill),.04))),t=gvjs_cZ(gvjs_bZ(this.m,"gantt.innerGridHorizLine"),gvjs_0p,gvjs_uj(gvjs_1z(gvjs_vj(q.fill),.12))),u=0;u<h;++u)p.push({rect:new gvjs_5(0,u*l+this.PB,m,l),options:u%2?r:q});for(q=1;q<h;++q)n.push({line:new gvjs_bA(0,q*l,m,q*l),options:t});p.push({rect:new gvjs_5(0,this.PB,this.eb.width,h*l),options:t});gvjs_vx===gvjs_J(this.m,gvjs_YY,gvjs_vt)?a.xp=-13.5:a.xp=h*l;h={lines:n,wS:p};k=gvjs_gla(this,b,a,l,k);l=gvjs_hla(this,b);m=[];p=gvjs_K(this.m,"gantt.shadowEnabled",
!0);n=gvjs_L(this.m,"gantt.shadowOffset");if(p&&0!=n)for(t=gvjs_L(this.m,gvjs_XY),p=gvjs_bZ(this.m,"gantt.shadowStyle"),0<t&&(p=Object.create(p),p[gvjs_$o]=t,p[gvjs_ap]=t),t=0;t<b.length;t++)q=b[t],0<q.Vw.length&&(r=q.zn,m.push({idx:q.yi,rect:new gvjs_5(r.left,r.top+n+this.PB,r.width,r.height),options:p}));d=gvjs_ila(this,b,d,e,f);b=gvjs_jla(this,b);e=[];a.draw(gvjs_s(this.Woa,this),gvjs_s(this.bma,this,e),gvjs_ye);return{Dka:e,background:g,grid:h,Tua:l,Pwa:m,size:this.eb,Lxa:b,Mxa:d,Nxa:k,u8:this.cH,
rga:c,nY:a.PC}};function gvjs_gla(a,b,c,d,e){var f=gvjs_L(a.m,gvjs_XY),g=[];gvjs_u(b,function(h,k){k=k*d+(d-e)/2+this.PB;var l=c.scale(h.Xd.getTime()),m=c.scale(h.yf.getTime());var n=this.cH;var p=h.Rea;if(!n.qa.has(p)){var q=n.qa,r=q.set;n.u1>=n.oh.length&&(n.u1=0);var t=n.u1++;r.call(q,p,t)}n=n.qa.get(p);h.UB=n;n=this.cH.color(n);k=new gvjs_5(l,k,m-l,e);h.zn=k;g.push({idx:h.yi,rect:new gvjs_5(k.left,k.top,k.width,k.height),options:{"corners.rx":f,"corners.ry":f,fill:n}})},a);return g}
function gvjs_hla(a,b){var c=[];if(gvjs_K(a.m,"gantt.percentEnabled",!0)){var d=gvjs_L(a.m,gvjs_XY),e=Object.create(gvjs_bZ(a.m,"gantt.percentStyle"));e[gvjs_bp]=d;e[gvjs_cp]=d;e[gvjs_dp]=0;e[gvjs_ep]=0;e[gvjs_6o]=d;e[gvjs_7o]=d;e[gvjs_8o]=0;e[gvjs_9o]=0;gvjs_u(b,function(f){var g=f.yi,h=f.dea,k=this.cH.qb(f.UB);if(null!=h&&0<h){var l=Object.create(e);l.fill=k;h=Math.min(100,h)/100;f=f.zn;(1-h)*f.width<d&&(l[gvjs_dp]=l[gvjs_ep]=l[gvjs_8o]=l[gvjs_9o]=d);c.push({idx:g,rect:new gvjs_5(f.left,f.top,h*
f.width,f.height),options:l})}},a)}return c}function gvjs_ela(a,b,c,d){var e=gvjs_L(a.m,"gantt.labelMaxWidth",300);b=b.reduce(function(f,g){g=a.Ww(g.getName(),c).width+2*d;return Math.max(g,f)},0);return Math.min(e,b)}function gvjs_ila(a,b,c,d,e){var f=c.bb,g=c.fontSize,h=[];gvjs_u(b,function(k){var l=k.yi,m=k.zn,n=this.cH.color(k.UB);h.push({idx:l,anchor:new gvjs_z(e-d,m.top+m.height/2),text:k.getName(),options:{fontFamily:f,fontSize:g,fill:n,halign:1,valign:.5}})},a);return h}
function gvjs_jla(a,b){var c=gvjs_L(a.m,"gantt.arrow.spaceAfter"),d=gvjs_L(a.m,"gantt.arrow.length"),e=gvjs_L(a.m,"gantt.arrow.angle"),f=gvjs_J(a.m,"gantt.arrow.color"),g=gvjs_L(a.m,"gantt.arrow.width"),h=gvjs_L(a.m,"gantt.arrow.radius"),k=a.m.pb("gantt.criticalPathStyle"),l=[];gvjs_u(b,function(m){var n=m.yi,p=m.zn,q=p.left+p.width/2,r=p.top+p.height;gvjs_u(m.Vw,function(t){var u=t.yi,v=t.zn,w=v.left-c;v=v.top+v.height/2;var x={fill:gvjs_f,stroke:f,strokeWidth:g},y=!1;m.qH&&t.qH&&(y=!0,x.stroke=
k.stroke,x.strokeWidth=k.strokeWidth);l.push({dma:y,rect:new gvjs_5(q,r,w-q,v-r),iQ:n,WI:u,options:x})},this)},a);return{zka:l,angle:e,length:d,radius:h}}
function gvjs_cla(a,b,c){var d=a.Xe;a=b.getValue(c,d.zra.index());var e=b.getValue(c,d.qw.index()),f=b.getValue(c,d.vL.index()),g=b.getValue(c,d.WH.index()),h=b.getValue(c,d.nna.index()),k=b.getValue(c,d.Rua.index()),l=null!=d.Qea?b.getValue(c,d.Qea.index()):"";b=b.getValue(c,d.Lma.index())||"";b=gvjs_Ee(b.split(","),function(m,n){null!=n&&(n=gvjs_kf(n),0<n.length&&m.push(n));return m},[]);return new gvjs_2Y(c,a,e,f,g,h,k,b,l)}gvjs_$Y.prototype.Woa=function(a,b){return this.Ww(a,b).width};
function gvjs_dla(a){var b=new gvjs_3Y;gvjs_u(a,function(c){b.sB(c)});return b}function gvjs_aZ(a,b,c){gvjs_u(b,function(d){d.yf.getTime()>=c&&!d.qH&&(d.qH=!0,a.push(d))})}gvjs_$Y.prototype.bma=function(a,b,c,d,e,f,g,h){a.push({anchor:new gvjs_z(c,d),text:b,options:{fontFamily:h.bb,fontSize:h.fontSize,fontWeight:h.bold?gvjs_st:gvjs_0v,fill:h.color,halign:gvjs_9Y[f],valign:gvjs_9Y[g]}});return{}};function gvjs_cZ(a,b,c){if(null==a)a={yDa:c};else if(null==a[b]||a[b]==gvjs_f)a[b]=c;return a}
function gvjs_fla(a){return gvjs_Ee(a,function(b,c){if(null===b.max||b.max<c.yf.getTime())b.max=c.yf;if(null===b.min||b.min>c.Xd.getTime())b.min=c.Xd;return b},{max:null,min:null})}function gvjs_bZ(a,b){var c=void 0===c?{}:c;return a.pb(b,null,function(d){d=gvjs_x(d);var e=gvjs_Qj(d.fill||c.fill)||gvjs_f;d.fill=e;e=gvjs_Pj(d.fillOpacity);null!=e&&(d.fillOpacity=e);e=gvjs_Qj(d.stroke||c.stroke);null!=e&&(d.stroke=e);e=gvjs_Nj(d.strokeWidth);null!=e&&(d.strokeWidth=e);return d})||{}};function gvjs_dZ(a){gvjs_OR.call(this);this.ua=a;this.xa=this.CE=this.Ys=null;this.rz=1;this.F=null}gvjs_o(gvjs_dZ,gvjs_OR);gvjs_=gvjs_dZ.prototype;gvjs_.Tb=function(){return this.ua.size};gvjs_.ZV=function(){var a=this.ua,b=[];gvjs_eZ(this,b,[a.background],null,gvjs_Wo);gvjs_eZ(this,b,a.grid.wS,null,gvjs_Pu);gvjs_kla(this,b,a.grid.lines);gvjs_fZ(this,b,this.ua.Dka,null,gvjs_Pu);return b};
gvjs_.AB=function(a){this.F=a.Oa().cp();var b=this.ua;a=[];var c=this.Ys?this.Ys.rb.ROW_INDEX:-1,d=this.Ys?this.Ys.rb.SOURCE:-1,e=-1;if(this.CE){var f=this.CE.rb.SUBTYPE;f&&0==f.indexOf("arrow")||(e=this.CE.rb.ROW_INDEX)}f=b.rga;var g=b.u8,h=gvjs_s(this.JW,this,[gvjs_s(this.GY,this,f,e,gvjs_s(g.jh,g)),gvjs_s(this.eka,this,f,c,d),gvjs_s(this.i$,this,f,c,d,gvjs_s(g.qb,g))]);gvjs_eZ(this,a,this.ua.Nxa,gvjs_os,gvjs_Cw,null,h);h=gvjs_s(this.JW,this,[gvjs_s(this.GY,this,f,e,gvjs_s(g.jh,g)),gvjs_s(this.i$,
this,f,c,d,function(k){k=g.qb(k);k=gvjs_vj(k);return gvjs_uj(gvjs_1z(k,.25))})]);gvjs_eZ(this,a,this.ua.Tua,gvjs_os,"rowoverlay",gvjs_ud,h);c=gvjs_s(this.JW,this,[gvjs_s(this.GY,this,f,e,function(){return gvjs_0Y[gvjs_Rr]}),gvjs_s(this.R6,this,f,c,d)]);gvjs_eZ(this,a,this.ua.Pwa,gvjs_os,"behindrows","shadows",c);gvjs_fZ(this,a,b.Mxa,gvjs_os,gvjs_Bw,"tasklabel");gvjs_lla(this,a,b.Lxa);this.xa&&(b=(new gvjs_rS([])).R(this.xa.layout,this.xa.offset),c=new gvjs_zR,gvjs_u(b,gvjs_s(c.add,c)),a.push(new gvjs_NR(c,
new gvjs_IL(gvjs_NQ),gvjs_Pd)));return a};gvjs_.JW=function(a,b,c){for(var d=a.length,e=0;e<d;++e)c=a[e].call(this,b,c)||c;return c};gvjs_.i$=function(a,b,c,d,e,f){var g=e.idx;a=a[g];if(b==g||c==g)f=f||Object.create(e.options),f.fill=d.call(this,a.UB);return f};gvjs_.GY=function(a,b,c,d,e){var f=d.idx;a=a[f];-1!=b&&b!=f&&(e=e||Object.create(d.options),e.fill=c.call(this,a.UB));return e};gvjs_.eka=function(a,b,c,d,e){return 0===a[d.idx].Vw.length?this.R6(a,b,c,d,e):null};
gvjs_.R6=function(a,b,c,d,e){a=d.idx;if(a==b||a==c)e=e||Object.create(d.options),e[gvjs_Xp]=0,e[gvjs_Yp]=2,e[gvjs_Wp]=1,e[gvjs_Vp]=.2;return e};
function gvjs_lla(a,b,c){var d=c.angle,e=c.length,f=c.radius,g=e*Math.cos(d*Math.PI/180),h=e*Math.sin(d*Math.PI/180),k=a.Ys?a.Ys.rb.ROW_INDEX:-1,l=a.Ys?a.Ys.rb.SOURCE:-1,m=a.CE?a.CE.rb.ROW_INDEX:-1;gvjs_u(c.zka,function(n){var p=null,q=!1,r=!1;if(0<=l)n.iQ==k&&n.WI==l&&(q=!0);else if(n.iQ==k||n.WI==k)q=!0;if(n.iQ==m||n.WI==m)r=!0;q&&(p=p||Object.create(n.options),p.strokeWidth=3);0<=m&&!r&&(p=p||Object.create(n.options),p.stroke=gvjs_0Y[gvjs_Rr]);p=p||n.options;p=new gvjs_Uq(p);var t=n.rect;q=t.left;
r=t.top;var u=q+t.width,v=r+t.height;t=Math.min(t.width,t.height);t=Math.min(t,f);p.move(q,r).line(q,v-t).arc(q+t,v-t,t,t,180,90,!1).line(u,v).move(u-g,v-h).line(u+1,v).line(u-g,v+h);q=gvjs_JL(n.iQ,"arrow"+n.WI);gvjs_KL(q,gvjs_5a,n.WI);b.push(new gvjs_NR(p,q,n.dma?"linksoverlay":gvjs_TQ))},a)}function gvjs_gZ(a,b,c,d,e,f,g){gvjs_u(c,function(h){if(d){var k=new gvjs_IL(d);null!=h.idx&&gvjs_KL(k,gvjs_ps,h.idx)}else k=this.ay();g&&gvjs_KL(k,gvjs_rs,g);b.push(new gvjs_NR(f.call(this,h),k,e))},a)}
function gvjs_eZ(a,b,c,d,e,f,g){gvjs_gZ(a,b,c,d,e,function(h){var k=g&&g.call(this,h,null);k=k||h.options;h=h.rect;return new gvjs_4Q(h.left,h.top,h.width,h.height,k)},f)}function gvjs_kla(a,b,c){gvjs_gZ(a,b,c,null,gvjs_Pu,function(d){var e=d.line;return new gvjs_3Q(e.x0,e.y0,e.x1,e.y1,d.options)})}function gvjs_fZ(a,b,c,d,e,f){gvjs_gZ(a,b,c,d,e,function(g){var h=g.options;return new gvjs_1Q(g.anchor.x,g.anchor.y,g.text,h)},f)}
gvjs_.ay=function(){var a=new gvjs_IL(gvjs_3r);gvjs_KL(a,gvjs_rs,"__internal_"+this.rz);this.rz+=1;return a};
gvjs_.bz=function(a,b){if(!b)this.xa=null;else if(!this.xa){a=this.ua.rga[Number(a.rb.ROW_INDEX)];var c=gvjs_7S(gvjs_$S(this.ua.nY));b=[];var d=c.tv(a.Xd,a.yf);b.push({title:"Duration:",subtitle:null,value:d,color:gvjs_0Y[gvjs_Tr]});b.push({title:"Percent done:",subtitle:null,value:""+a.dea+" %",color:gvjs_0Y[gvjs_Tr]});d=a.Rea;null!=d&&0<d.length&&b.push({title:"Resource:",subtitle:null,value:d,color:this.ua.u8.color(a.UB)});a.qH&&b.push({title:"Is on critical path",subtitle:null,value:"",color:gvjs_0Y[gvjs_Tr]});
c=c.format(a.Xd,a.yf);c=a.getName()+": "+c;d=this.F.me;b=(new gvjs_iS).define(c,b).layout(d,{});c=this.Tb();c=new gvjs_5(0,0,c.width,c.height);a=(new gvjs_mS(c,a.zn,new gvjs_A(b.width(),b.height()),new gvjs_z(1,0))).position();this.xa={layout:b,offset:new gvjs_z(gvjs_0g(a.x,c.left,c.left+c.width-b.width()),gvjs_0g(a.y,c.top,c.top+c.height-b.height()))}}};gvjs_.nm=function(a,b,c){b.type==gvjs_xu?this.Ys=c?a:null:b.type==gvjs_k?this.CE=c?a:null:b.type==gvjs_Pd&&this.bz(a,c)};function gvjs_hZ(a){gvjs_UL.call(this,a)}gvjs_o(gvjs_hZ,gvjs_UL);gvjs_=gvjs_hZ.prototype;gvjs_.xq=function(){return{ROW_INDEX:gvjs_Cd}};
gvjs_.og=function(){return{backgroundColor:{fill:gvjs_ea},gantt:{arrow:{angle:45,color:gvjs_0Y[gvjs_Vr],length:8,radius:30,spaceAfter:8,width:1.4},barCornerRadius:5,barHeight:null,criticalPathEnabled:!0,criticalPathStyle:{stroke:gvjs_TF[gvjs_Sr],strokeWidth:1.4},defaultStartDate:null,innerGridHorizLine:{stroke:null,strokeWidth:1},innerGridTrack:{fill:null},innerGridDarkTrack:{fill:null},labelMaxWidth:300,labelStyle:{fontName:gvjs_qs,fontSize:14,color:gvjs_0Y[gvjs_Tr]},percentEnabled:!0,percentStyle:{fill:gvjs_ca},
shadowEnabled:!0,shadowStyle:{fill:gvjs_0Y[gvjs_Vr]},shadowOffset:1,trackHeight:null}}};gvjs_.Al=function(a,b,c,d){return new gvjs_$Y(a,b,c,d)};gvjs_.xs=function(){return[new gvjs_JR([new gvjs_IL(gvjs_os)]),new gvjs_LR([new gvjs_IL(gvjs_os)]),new gvjs_MR([new gvjs_IL(gvjs_os)])]};gvjs_.Mm=function(a,b){return new gvjs_dZ(a,b)};gvjs_.po=function(a,b,c,d){a=new gvjs_AR(this,a,b,c,d);a.$t([gvjs_Wo,gvjs_Pu,gvjs_TQ,"linksoverlay","behindrows",gvjs_Cw,"rowoverlay",gvjs_Bw,gvjs_Pd]);return a};
gvjs_.nH=function(a,b){null==this.sb?this.sb=new gvjs_oR(this.container,a,b,[gvjs_qs,gvjs_LQ]):this.sb.update(a,b)};gvjs_q(gvjs_lc,gvjs_hZ,void 0);gvjs_hZ.prototype.draw=gvjs_hZ.prototype.draw;gvjs_hZ.prototype.setSelection=gvjs_hZ.prototype.setSelection;gvjs_hZ.prototype.getSelection=gvjs_hZ.prototype.getSelection;gvjs_hZ.prototype.clearChart=gvjs_hZ.prototype.Jb;