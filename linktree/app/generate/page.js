"use client"
import React, { useState } from 'react'
import { useSearchParams } from 'next/navigation'
import { ToastContainer, toast } from 'react-toastify';
const generate = () => {
    const searchParams = useSearchParams()
    const [handler, sethandler] = useState(searchParams.get('handler'))
    const [links, setLinks] = useState([{ link: "", linkText: "" }])
    const [pic, setpic] = useState("")
    const [desc, setDesc] = useState("")
    const handleChange = (index, link, linkText) => {
        setLinks((initialLink) => {
            return initialLink.map((item, i) => {
                if (i == index) {
                    return { link, linkText }
                }
                else {
                    return item
                }
            })
        })
    }
    const addLink = () => {
        setLinks(links.concat([{ link: "", linkText: "" }]))
    }
    const submitLinks = async () => {
        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const raw = JSON.stringify({
            "handler": handler,
            "links": links,
            "pic": pic,
            "desc": desc
        });

        const requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: raw,
            redirect: "follow"
        };

        const r = await fetch("http://localhost:3000/api/add", requestOptions)
        // const r = await fetch("http://192.168.1.2:3000/api/add", requestOptions)
        const result = await r.json()
        if(result.success){
            toast.success(result.message, {
                position: "bottom-right",
                autoClose: 5000,
                hideProgressBar: false,
                closeOnClick: false,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
                theme: "dark",
                });
                setLinks([])
                sethandler("")
                setpic("")
                setDesc("")
        }
        else{
            toast.error(result.message, {
                position: "bottom-right",
                autoClose: 5000,
                hideProgressBar: false,
                closeOnClick: false,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
                theme: "dark",
                })
        }
    }

    console.log(handler)
    

    return (

        <div className='w-full min-h-screen bg-[#e8c1e7] grid grid-cols-2 text-gray-700' >
            <div className="inputs flex justify-center w-[25vw] mx-auto flex-col">
            <h2 className='text-4xl font-bold text-black'>Create your LinkTree</h2>
                <div className="input my-5">
                    <h3>Holder Name</h3>
                    <input value={handler || ""} onChange={e => { sethandler(e.target.value) }} type="text" name="handler" id="handler" placeholder='Enter handler name' className='rounded-md py-2 px-4 focus:outline-pink-600 ' />
                </div>
                <div className="input flex flex-col gap-4">
                    <h3>Links</h3>
                    {links && links.map((item, index) => {
                        return <div key={index}>
                            <input value={item.linkText } onChange={e => { handleChange(index, item.link, e.target.value) }} type="text" name="linkText" id="linkText" placeholder='Enter link Text' className='rounded-lg py-2 px-4 focus:outline-pink-600 ' />
                            <input value={item.link} onChange={e => { handleChange(index, e.target.value, item.linkText) }} type="text" name="link" id="link" placeholder='Enter link URL' className='rounded-md py-2 px-4 mx-4 focus:outline-pink-600 ' />
                        </div>
                    })}
                    <button onClick={addLink} className='bg-slate-800 hover:bg-slate-900 text-white font-semibold text-lg py-2 px-10 rounded-xl w-fit'>+ Add</button>
                </div>
                <div className="input my-5">
                    <h3>Picture</h3>
                    <input value={pic || ""} onChange={e => { setpic(e.target.value) }} type="text" name="pic" id="pic" placeholder='Enter profile pic URL' className='rounded-md py-2 px-4 focus:outline-pink-600 ' />
                    <input value={desc || ""} onChange={e => { setDesc(e.target.value) }} type="text" name="desc" id="desc" placeholder='Enter profile description' className='rounded-md py-2 px-4 mx-5 focus:outline-pink-600 ' />
                </div>
                <button disabled={pic=="" || desc=="" || links[0].linkText=="" || links[0].link=="" || handler==""} onClick={submitLinks} className='bg-slate-800 disabled:bg-slate-500 hover:bg-slate-900 text-white py-2 px-16 rounded-xl w-fit'>Generate</button>

            </div>
            <div className="image flex justify-start items-center">
                <img src="/layout3.jpg" alt="" />
                <ToastContainer />
            </div>
        </div>
    )
}

export default generate
