import{K as _,r as b,o as r,c as o,b as l,F as u,f as m,j as y,u as p,t as f,g as h,q as v,x as w,n as F,k as S,a as D}from"./app-13e8b3b3.js";import{L}from"./Label-4bef15bf.js";import{P as T}from"./PaginatorLinks-c80dab43.js";import{_ as C}from"./_plugin-vue_export-helper-c27b6911.js";const H={components:{PaginatorLinks:T,Label:L},computed:{request(){var s,e,t;return((e=(s=_().props)==null?void 0:s.value)==null?void 0:e.request)||((t=_().props)==null?void 0:t.request)||{}}},props:{serialColumn:{type:Boolean,default:!1},bottomLinks:{type:Boolean,default:!0},collections:{type:Object,default:{}},filters:{type:Object,default:{}},columns:{type:Array,default:[]},dateFilter:{type:Boolean,default:!1},varientDateFilter:{type:Object,default:{7:"Last 7 days",15:"Last 15 days",30:"Last 30 days",90:"Last 90 days",180:"Last 180 days",365:"Last 365 days"}}},created(){Object.entries(this.filters).forEach(([s,e])=>{this.filterData[s]=this.request[s]||""}),this.dateFrom=this.request.from||"",this.dateTo=this.request.to||"",this.search=this.request.search||""},data(){return{perpage:this.collections.meta.per_page,search:"",filterData:{},data:{},dateFrom:"",dateTo:"",valueDateFilter:""}},methods:{searchHandler(){this.data.perpage=this.perpage,Object.entries(this.filterData).forEach(([e,t])=>{this.data[e]=t}),this.data.from=this.dateFrom,this.data.to=this.dateTo,this.data.search=this.search;let s=this.route(this.routeName||this.route().current(),this.clean(this.data));localStorage.setItem("historyOfList",s),this.$inertia.get(s,{},{preserveState:!0})},dateSearchHandler(s){const e=parseInt(s.target.value),t=new Date,g=new Date(t.getTime()-e*24*60*60*1e3);e?(this.dateFrom=`${g.getFullYear()}-${(g.getMonth()+1).toString().padStart(2,"0")}-${g.getDate().toString().padStart(2,"0")}`,this.dateTo=`${t.getFullYear()}-${(t.getMonth()+1).toString().padStart(2,"0")}-${t.getDate().toString().padStart(2,"0")}`):(this.dateFrom="",this.dateTo=""),this.searchHandler()},clean(s){for(var e in s)(s[e]===""||s[e]===null||s[e]===void 0)&&delete s[e];return s}}},q={class:"flex w-full flex-col gap-4"},V={class:"flex flex-wrap gap-4"},O=["onUpdate:modelValue","name"],j={value:"",selected:""},B=["value"],U={key:1,class:"order-1 ml-auto flex w-full flex-col items-end justify-between gap-2 sm:flex-row lg:order-2 lg:w-auto lg:max-w-xl"},I={class:"flex w-full max-w-sm items-center justify-end gap-1"},M=l("option",{value:""},"Custom Date",-1),A=["value"],E={class:"flex w-full max-w-sm items-center justify-end gap-1"},z=["max"],N={class:"flex w-full max-w-sm items-center justify-end gap-1"},P=["min"],Y={class:"overflow-x-auto"},K={class:"inline-block min-w-full align-middle"},G={class:"overflow-hidden"},J={class:"min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700"},Q={class:"bg-gray-300 dark:bg-gray-700"},R={key:0,class:"py-3 px-6 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 md:text-sm"},W={class:"divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"},X={key:0,class:"whitespace-nowrap py-4 px-6 text-xs font-medium text-gray-900 dark:text-white md:text-sm"},Z={key:0,class:"hover:bg-gray-100 dark:hover:bg-gray-700"},$=l("td",{colspan:"100",class:"py-3 px-2 text-center text-red-500"}," No data found !! ",-1),ee=[$],te={key:0,class:"w-full p-1"};function ae(s,e,t,g,n,d){const k=b("paginator-links");return r(),o(u,null,[l("div",q,[l("div",V,[Object.keys(t.filters).length?(r(!0),o(u,{key:0},m(t.filters,(a,i)=>(r(),o("div",{class:"flex w-full sm:w-auto",key:i},[y(l("select",{onChange:e[0]||(e[0]=(...c)=>d.searchHandler&&d.searchHandler(...c)),"onUpdate:modelValue":c=>n.filterData[i]=c,name:i,class:"block w-full max-w-sm shadow-sm focus:outline-none focus:ring-0"},[l("option",j,f(i.replaceAll("_"," ").toLowerCase().replace(/\b[a-z]/g,function(c){return c.toUpperCase()}))+" (All) ",1),(r(!0),o(u,null,m(a,(c,x)=>(r(),o("option",{key:x,value:x},f(c),9,B))),128))],40,O),[[p,n.filterData[i]]])]))),128)):h("",!0),t.dateFilter?(r(),o("div",U,[l("div",I,[y(l("select",{onChange:e[1]||(e[1]=(...a)=>d.dateSearchHandler&&d.dateSearchHandler(...a)),"onUpdate:modelValue":e[2]||(e[2]=a=>n.valueDateFilter=a),class:"block w-full min-w-max cursor-pointer shadow-sm focus:outline-none focus:ring-0"},[M,(r(!0),o(u,null,m(t.varientDateFilter,(a,i)=>(r(),o("option",{key:i,value:i},f(a),9,A))),128))],544),[[p,n.valueDateFilter]])]),l("div",E,[y(l("input",{onInput:e[3]||(e[3]=(...a)=>d.searchHandler&&d.searchHandler(...a)),"onUpdate:modelValue":e[4]||(e[4]=a=>n.dateFrom=a),max:this.dateTo,type:"date",class:"block w-full max-w-xs shadow-sm focus:outline-none focus:ring-0"},null,40,z),[[v,!n.valueDateFilter],[w,n.dateFrom]])]),l("div",N,[y(l("input",{onInput:e[5]||(e[5]=(...a)=>d.searchHandler&&d.searchHandler(...a)),"onUpdate:modelValue":e[6]||(e[6]=a=>n.dateTo=a),min:this.dateFrom,type:"date",class:"block w-full max-w-xs shadow-sm focus:outline-none focus:ring-0"},null,40,P),[[v,!n.valueDateFilter],[w,n.dateTo]])])])):h("",!0)]),l("div",Y,[l("div",K,[l("div",G,[l("table",J,[l("thead",Q,[l("tr",null,[t.serialColumn?(r(),o("th",R," SL ")):h("",!0),(r(!0),o(u,null,m(t.columns,(a,i)=>(r(),o("th",{key:i,class:F(["py-3 px-6 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 md:text-sm",{"text-left":a.align=="left","text-center":a.align=="center","text-right":a.align=="right"}])},f(a.title),3))),128))])]),l("tbody",W,[(r(!0),o(u,null,m(t.collections.data,(a,i)=>(r(),o("tr",{key:i,class:"hover:bg-gray-100 dark:hover:bg-gray-700"},[t.serialColumn?(r(),o("td",X,f(t.collections.meta.total+1-(t.collections.meta.from+i)),1)):h("",!0),S(s.$slots,"default",{item:a})]))),128)),t.collections.meta.total?h("",!0):(r(),o("tr",Z,ee))])])])])])]),t.collections.meta.total&&t.bottomLinks?(r(),o("div",te,[D(k,{collections:t.collections},null,8,["collections"])])):h("",!0)],64)}const ie=C(H,[["render",ae]]);export{ie as S};
