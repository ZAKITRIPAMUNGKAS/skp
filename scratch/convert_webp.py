import os
import glob
from PIL import Image

def convert_to_webp(source_path, target_path=None, quality=80):
    if not target_path:
        base, _ = os.path.splitext(source_path)
        target_path = base + ".webp"
    
    try:
        with Image.open(source_path) as img:
            # Convert RGBA to RGB if needed for non-transparent targets
            # but webp supports transparency so RGBA is fine.
            img.save(target_path, "WEBP", quality=quality)
            print(f"Converted: {source_path} -> {target_path} ({os.path.getsize(target_path)} bytes)")
            return True
    except Exception as e:
        print(f"Failed to convert {source_path}: {e}")
        return False

if __name__ == "__main__":
    public_dir = r"D:\website\SKRIPSI\SISTEM\public"
    
    # 1. Convert D:\website\SKRIPSI\SISTEM\public\hero.JPG
    convert_to_webp(os.path.join(public_dir, "hero.JPG"))
    
    # 2. Convert D:\website\SKRIPSI\SISTEM\public\kegiatan.JPG
    convert_to_webp(os.path.join(public_dir, "kegiatan.JPG"))
    
    # 3. Convert D:\website\SKRIPSI\SISTEM\public\logo.png to logo.webp
    convert_to_webp(os.path.join(public_dir, "logo.png"))
    
    # 4. Convert all images in public/images/arka
    arka_dir = os.path.join(public_dir, "images", "arka")
    for f in glob.glob(os.path.join(arka_dir, "*.png")):
        convert_to_webp(f)
        
    # 5. Convert all images in public/images/gallery
    gallery_dir = os.path.join(public_dir, "images", "gallery")
    for f in glob.glob(os.path.join(gallery_dir, "*.png")):
        convert_to_webp(f)
        
    # 6. Convert all images in public/images/testimonials
    testi_dir = os.path.join(public_dir, "images", "testimonials")
    for f in glob.glob(os.path.join(testi_dir, "*.png")):
        convert_to_webp(f)

    print("Conversion finished.")
