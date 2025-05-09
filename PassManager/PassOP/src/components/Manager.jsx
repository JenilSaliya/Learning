import React,{useRef,useState,useEffect} from 'react'
import { v4 as uuidv4 } from 'uuid'

const Manager = () => {
  // const [sid, setsid] = useState(0)
  const [passArray, setpassArray] = useState([])
  const ref = useRef()
  const [form, setform] = useState({id:"",siteName:"",userName:"",password:""})
  const passRef = useRef()
  const handleImageClick = () =>{
    if(ref.current.src.includes('/hidden.png')){
      let ans=confirm('Show Password')
      if(ans){
        ref.current.src='/eye.png'
        passRef.current.type='text'
      }
    }
    else{
      ref.current.src='/hidden.png'
      passRef.current.type='password'
  } 
  }
  useEffect(() => {
    
    // setform({...form,id:sid})
    // setsid(sid+1)
    let passwords = localStorage.getItem("passwords")
    if(passwords){
      setpassArray(JSON.parse(passwords))
    }
  
    
  }, [])
  
  const handleSave = () =>{
    // setform({...form,id:sid})
    //   setsid(sid+1)
    if(form.siteName.length>1 && form.userName.length>1 && form.password.length>3){
      setpassArray([...passArray,{...form,id:uuidv4()}])
      localStorage.setItem("passwords",JSON.stringify([...passArray,{...form,id:uuidv4()}]))
      setform({id:"",siteName:"",userName:"",password:""})}
      else{
        alert("all field must not have blank")
      }
  }
  const handleChange = (e) => {
    setform({...form,[e.target.name]:e.target.value})
  }

  const copyText = (text) =>{
    navigator.clipboard.writeText(text)
  } 

  const handleDelete = (id,siteName) =>{
    let c =  confirm("sure, you want to delete :" + siteName)
    if(c){
    console.log("deleting password with id " + id)
    setpassArray(passArray.filter(item=>item.id!==id))
    localStorage.setItem("passwords",JSON.stringify([passArray.filter(item=>item.id!==id)]))}
    
  }
  const handleEdit = (id) =>{
    console.log("editing password with id " + id)
    setform(passArray.filter(i=>i.id==id)[0])
    setpassArray(passArray.filter(item=>item.id!==id))

  }

  
  return (
    <div className='w-full min-h-[87vh] bg-slate-950 text-white flex items-center flex-col'>
      <div className=' w-1/3 border border-s-2 rounded-2xl p-5 mt-[70px]'>
          <div className='flex justify-between items-center'>
          <h2 className='text-2xl font-bold'> &lt;Passs<span className='text-slate-400'>OP</span>&gt;</h2>
          <p>The Password Manager</p>
          </div>
          <div className='flex flex-col justify-center items-center'>
          <input type="text" name="siteName" value={form.siteName} onChange={handleChange} className='border rounded-md w-full mt-[100px] px-4 text-black py-[2px]' placeholder='Enter Site URL'/>
          <div className='flex flex-row my-[25px] gap-2 w-full'>
            <input type="text" name="userName" value={form.userName} onChange={handleChange} className='px-4 rounded-md w-1/2 text-black py-[2px]' placeholder='Enter User Name'/>
            <div className='relative flex items-center w-1/2'>
              <img src="/hidden.png" ref={ref} alt="" className='absolute w-5 right-1 cursor-pointer' onClick={handleImageClick}/>
              <input ref={passRef} type="password" value={form.password} onChange={handleChange} className='px-4 rounded-md w-full text-black  py-[2px]' placeholder='Enter Password' name="password"/>
            </div>
          </div>
            <button className='bg-slate-800 rounded-full hover:font-bold hover:bg-slate-700 flex items-center justify-center' onClick={handleSave}><img src="/icons8-add-64.png" className='w-11' alt="Save" /><span className='text-lg pr-[7px]'>Add</span></button>
          </div>
      </div>
      {passArray.length === 0 && <div className='mt-16'>Password not save yet</div>}
      {passArray.length != 0 && <table className='border border-white border-collapse mt-[100px] w-1/3 text-center'>
          <thead>
            <tr className='border border-white'>
              <th className='border border-white px-3 py-2'>Site Name</th>
              <th className='border border-white px-3 py-2'>User Name</th>
              <th className='border border-white px-3 py-2'>Password</th>
              <th className='border border-white px-3 py-2'>Action</th>
            </tr>
          </thead>
          <tbody>
            {passArray.map((item)=>{
              return <tr key={item.id} className='border border-white'> 
              <td className='border border-white px-3 py-2 '><div className='flex items-center justify-center gap-1'><a href={item.siteName} target='_blank' >{item.siteName}</a> <img src="/icons8-copy-24.png" alt="copy" className='invert h-5 cursor-pointer' onClick={()=>{copyText(item.siteName)}}/></div></td>
              <td className='border border-white px-3 py-2 '><div className='flex items-center justify-center gap-1'>{item.userName} <img src="/icons8-copy-24.png" alt="copy" className='invert h-5 cursor-pointer' onClick={()=>{copyText(item.userName)}}/></div></td>
              <td className='border border-white px-3 py-2 '><div className='flex items-center justify-center gap-1'>{"*".repeat(item.password.length)}<img src="/icons8-copy-24.png" alt="copy" className='invert h-5 cursor-pointer' onClick={()=>{copyText(item.password)}}/></div></td>
              <td className='flex items-center justify-center mt-[3px] gap-2'>
                <button className='m-1 bg-slate-800 px-3 hover:bg-slate-700 rounded-md'><img src="/icons8-edit-24.png" className='invert' alt="Edit" onClick={()=>{handleEdit(item.id)}}/></button>
                <button className='m-1 bg-slate-800 px-3 hover:bg-slate-700  rounded-md'><img src="/icons8-delete-50.png" className='h-[25px] w-[30px] ' alt="delete" onClick={()=>{handleDelete(item.id,item.siteName)}}/></button>
              </td>
            </tr>
            })}
          </tbody>
        </table>}
    </div>
  )
}

export default Manager
