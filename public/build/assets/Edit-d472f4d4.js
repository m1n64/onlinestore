import{_ as r}from"./AuthenticatedLayout-6a40bca0.js";import i from"./DeleteUserForm-5554aaf0.js";import m from"./UpdatePasswordForm-58452809.js";import n from"./UpdateProfileInformationForm-0fa8d13e.js";import{b as u,l as t,u as f,w as a,F as c,o as p,H as _,e as s,f as d,t as x}from"./app-3f9c2e80.js";import{C as e}from"./CardComponent-1cda08fe.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./InputError-9082d8e1.js";import"./InputLabel-5f55ef2c.js";import"./SecondaryButton-8b11777f.js";import"./TextInput-3bf61901.js";import"./PrimaryButton-2e0e51ac.js";const h=s("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"},"Profile",-1),g={class:"py-12"},y={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"},S={__name:"Edit",props:{mustVerifyEmail:Boolean,status:String},setup(o){return(l,w)=>(p(),u(c,null,[t(f(_),{title:"Profile"}),t(r,null,{header:a(()=>[h]),default:a(()=>[s("div",g,[s("div",y,[t(e,{"head-text":"Main information:"},{default:a(()=>[d(" Your role: "+x(l.$page.props.auth.user.role_name),1)]),_:1}),t(e,null,{default:a(()=>[t(n,{"must-verify-email":o.mustVerifyEmail,status:o.status,class:"max-w-xl"},null,8,["must-verify-email","status"])]),_:1}),t(e,null,{default:a(()=>[t(m,{class:"max-w-xl"})]),_:1}),t(e,null,{default:a(()=>[t(i,{class:"max-w-xl"})]),_:1})])])]),_:1})],64))}};export{S as default};