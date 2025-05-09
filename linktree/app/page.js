"use client"

import { useRouter } from "next/navigation";
import { useState } from "react";


export default function Home() {
  const router = useRouter()
  const [handler, sethandler] = useState("")
  const createLinkTree = () =>{
    router.push(`/generate?handler=${handler}`)
  }
  return (
   <main>
     <section className="bg-[#274e1e] min-h-screen w-full grid md:grid-cols-2 justify-center items-center px-[11vw] ">
      <div className="p-6"> 
        <h1 className="text-[#d5e43d] text-7xl font-bold">
          Everything you are. In one, simple link in bio.
        </h1>
        <p className="text-[#d5e43d] my-5 text-xl">
          Join 50M+ people using Linktree for their link in bio. One link to help you share everything you create, curate and sell from your Instagram, TikTok, Twitter, YouTube and other social media profiles.
        </p>
        <div className="input my-10">
          <input value={handler} onChange={e=>{sethandler(e.target.value)}} type="text" name="" id="" placeholder="Your name" className="p-4 rounded-md" />
          <button disabled={handler==""} onClick={()=>{createLinkTree()}} className="bg-[#e8c1e7] disabled:bg-pink-100 mx-2 rounded-full py-4 px-6 font-semibold">Claim your Linktree</button>
        </div>
      </div>
      <div className="p-0 flex items-center justify-start">
        <img src="/layout.jpg" alt="" />
      </div>
    </section>
    <section className="bg-[#e8c1e7] min-h-screen w-full grid grid-cols-2 justify-center items-center px-[11vw]">
      <div>
      <img src="/layout2.jpg" alt="" />
      </div>
      <div></div>
    </section>
   </main>
  );
}
