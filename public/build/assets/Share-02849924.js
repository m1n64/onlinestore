import{b as c,l as a,u as o,w as r,F as _,o as d,H as m,e as t,t as l,f as n,a as p}from"./app-3f9c2e80.js";import{_ as u}from"./GuestLayout-bea812e9.js";import{_ as x,f as i}from"./MultimediaView-e21ed19e.js";const h={class:"flex flex-col"},w={class:"text-xl font-bold"},y={class:"flex justify-between my-2"},k={class:"text-gray-600"},v=["href","download"],F={__name:"Share",props:{file:{type:Object,default:{}},fileExpired:{type:String,default:""}},setup(f){const e=f;return(b,g)=>{const s=p("font-awesome-icon");return d(),c(_,null,[a(o(m),{title:"File "+e.file.name},null,8,["title"]),a(u,null,{default:r(()=>[t("div",h,[t("div",null,[t("div",w,l(e.file.name),1),a(x,{link:e.file.full_file_path,"mime-type":e.file.mime_type,class:"my-2 w-full"},null,8,["link","mime-type"]),t("div",y,[t("span",null,[a(s,{icon:"fa-solid fa-user"}),n(" "+l(e.file.user.name),1)]),t("span",null,[a(s,{icon:"fa-regular fa-clock"}),n(" "+l(o(i)(e.file.created_at)),1)])]),t("div",k,"Link expired at: "+l(o(i)(e.fileExpired)),1)]),t("a",{href:e.file.download_link,download:e.file.name,class:"btn main text-center mt-4"},"Download",8,v)])]),_:1})],64)}}};export{F as default};