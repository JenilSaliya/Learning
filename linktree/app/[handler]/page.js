import Link from "next/link"
import clientPromise from "@/lib/mongodb"
import { notFound } from "next/navigation";

export default async function Page({ params }) {
    const handler = (await params).handler
    // const item =  {
    //     handler:"jenil",
    //     pic:"/layout.jpg",
    //     links:[{
    //         linkText:"youtube",
    //         link:"https://www.youtube.com"
    //     },
    //     {
    //         linkText:"faceboook",
    //         link:"https://www.facebook.com"
    //     },{
    //         linkText:"instagram",
    //         link:"https://www.instagram.com"
    //     },{
    //         linkText:"cahtgpt",
    //         link:"https://www.cahtgpt.com"
    //     }
    // ],
    // desc:"hello i am jenil saliya and i am a fullstack web devloper "

    // }
    const client = await clientPromise;
    const db = client.db("linkTree")
    const collection = db.collection("links")
    const item = await collection.findOne({handler})
    if(!item){
        return notFound()
    }
    return (
        <div className="min-h-screen flex justify-center  items-start bg-black text-white py-20">
          
            <div className="flex flex-col">
            <div className="photo flex items-center flex-col gap-3">
            <img src={item.pic} alt="profile pic" className="w-28 rounded-full"/>
           <span className="font-bold text-3xl">{item.handler}</span>
            <span className="w-80 text-lg text-center">{item.desc}</span>
            </div>
            <div className="links my-8">
                {item.links.map((item,index) => {
                  return <Link href={item.link} key={index} target="_blank"> <div className="link my-4 py-4 rounded-lg bg-slate-700 px-2 text-center ">{item.linkText}</div></Link>
                }
                )}
            </div>
           </div>
         
        </div>
    )
  }
