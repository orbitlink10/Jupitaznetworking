import { readFileSync, writeFileSync, mkdirSync, existsSync } from 'node:fs';
import { execFileSync } from 'node:child_process';
const pages = {
 'mikrotik-rb5009ug-s-in':'https://mikrotik.com/product/rb5009ug_s_in',
 'mikrotik-rb4011igs-rm':'https://mikrotik.com/product/rb4011igs_rm',
 'mikrotik-router-hex-s-rb760igs':'https://mikrotik.com/product/hex_s',
 'mikrotik-hex-rb750gr3':'https://mikrotik.com/product/RB750Gr3',
 'mikrotik-l009uigs-rm':'https://mikrotik.com/product/l009uigs_rm',
 'mikrotik-ccr2004-16g-2s':'https://mikrotik.com/product/ccr2004_16g_2splus',
 'ubiquiti-u6-plus':'https://store.ui.com/us/en/products/u6-plus',
 'ubiquiti-u6-lr':'https://store.ui.com/us/en/products/u6-lr',
 'ubiquiti-u7-pro':'https://store.ui.com/us/en/products/u7-pro',
 'ubiquiti-litebeam-m5-23':'https://store.ui.com/us/en/products/lbe-m5-23',
 'ubiquiti-litebeam-5ac-gen2':'https://store.ui.com/us/en/products/litebeam-5ac',
 'ubiquiti-nanobeam-5ac-gen2':'https://store.ui.com/us/en/products/nanobeam-5ac',
 'tp-link-archer-c6':'https://www.tp-link.com/en/home-networking/wifi-router/archer-c6/',
 'tp-link-archer-c54':'https://www.tp-link.com/en/home-networking/wifi-router/archer-c54/',
 'tp-link-archer-c80':'https://www.tp-link.com/en/home-networking/wifi-router/archer-c80/',
 'tp-link-archer-ax23':'https://www.tp-link.com/en/home-networking/wifi-router/archer-ax23/',
 'tp-link-tl-sg108':'https://www.tp-link.com/en/business-networking/unmanaged-switch/tl-sg108/',
 'tp-link-tl-sg1016d':'https://www.tp-link.com/en/business-networking/unmanaged-switch/tl-sg1016d/',
 'tp-link-tl-sg1024d':'https://www.tp-link.com/en/business-networking/unmanaged-switch/tl-sg1024d/',
 'tp-link-tl-sg1008p':'https://www.tp-link.com/en/business-networking/poe-switch/tl-sg1008p/',
 'd-link-dgs-1008a':'https://www.dlink.com/en/products/dgs-1008a-8-port-gigabit-easy-desktop-switch',
 'd-link-dgs-1024d':'https://www.dlink.com/en/products/dgs-1024d-24-port-gigabit-unmanaged-desktop-switch',
 'd-link-dgs-1210-28p':'https://www.dlink.com/en/products/dgs-1210-28p-28-port-gigabit-smart-managed-poe-switch',
};
mkdirSync('public/images/products', {recursive:true});
const sources=existsSync('public/images/products/sources.json') ? JSON.parse(readFileSync('public/images/products/sources.json','utf8')) : {};
for (const [slug,url] of Object.entries(pages)) {
 if(sources[slug] && existsSync('public/'+sources[slug].path)) continue;
 try {
  const html=execFileSync('curl.exe',['-sL','--max-time','25',url],{maxBuffer:12000000}).toString();
  writeFileSync(`storage/app/${slug}.html`,html);
  const tags=html.match(/<meta\b[^>]*>/gi)||[];
  const tag=tags.find(t=> /(?:property|name)=["']og:image["']/i.test(t));
  let image=tag?.match(/content=["']([^"']+)/i)?.[1]?.replaceAll('&amp;','&');
  if(!image && url.includes('mikrotik')) image=html.match(/https:\/\/cdn\.mikrotik\.com\/web-assets\/product_files\/[^"\s<>]+\.(?:png|jpg)/i)?.[0];
  if(!image) { console.log('NO IMAGE '+slug); continue; }
  image=new URL(image,url).href;
  const bytes=execFileSync('curl.exe',['-sL','--max-time','25',image],{maxBuffer:15000000});
  const isPng=bytes[0]===137 && bytes[1]===80, isJpg=bytes[0]===255 && bytes[1]===216, isWebp=bytes.subarray(8,12).toString()==='WEBP';
  if(!isPng&&!isJpg&&!isWebp) { console.log('INVALID '+slug+' '+image); continue; }
  const path=`images/products/${slug}.${isPng?'png':isJpg?'jpg':'webp'}`;
  writeFileSync('public/'+path,bytes); sources[slug]={path,source:url,image}; console.log('OK '+slug);
 } catch(e) { console.log('FAILED '+slug); }
}
writeFileSync('public/images/products/sources.json',JSON.stringify(sources,null,2));
