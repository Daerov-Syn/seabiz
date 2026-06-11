from PIL import Image, ImageDraw
import os

base_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'public', 'assets', 'img')
os.makedirs(base_dir, exist_ok=True)


def make_canvas(size=(800, 600), bg=(248, 250, 252)):
    img = Image.new('RGB', size, bg)
    draw = ImageDraw.Draw(img)
    return img, draw


def save(img, name):
    img.save(os.path.join(base_dir, name), 'PNG')


def fish_red():
    img, draw = make_canvas()
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(237, 246, 255), outline=(200, 220, 240), width=6)
    # water waves
    draw.ellipse((80, 120, 220, 260), fill=(14, 116, 190), outline=(14, 116, 190))
    draw.ellipse((180, 120, 320, 260), fill=(30, 144, 255), outline=(30, 144, 255))
    draw.ellipse((500, 120, 640, 260), fill=(14, 116, 190), outline=(14, 116, 190))
    draw.ellipse((600, 120, 740, 260), fill=(30, 144, 255), outline=(30, 144, 255))
    # fish body
    draw.ellipse((180, 220, 560, 420), fill=(255, 127, 80), outline=(220, 90, 50), width=8)
    draw.polygon([(500, 270), (640, 240), (620, 320)], fill=(255, 127, 80), outline=(220, 90, 50), width=6)
    draw.ellipse((260, 270, 330, 335), fill=(255, 255, 255), outline=(220, 220, 220), width=4)
    draw.ellipse((285, 282, 315, 312), fill=(15, 23, 42))
    draw.line((340, 300, 420, 300), fill=(220, 90, 50), width=6)
    return img


def shrimp():
    img, draw = make_canvas(bg=(255, 248, 240))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(255, 238, 219), outline=(240, 203, 167), width=6)
    # shrimp body
    draw.ellipse((190, 210, 610, 430), fill=(255, 140, 66), outline=(209, 90, 35), width=8)
    draw.ellipse((480, 250, 620, 380), fill=(255, 107, 53), outline=(209, 90, 35), width=8)
    draw.polygon([(175, 280), (95, 240), (100, 320)], fill=(255, 140, 66), outline=(209, 90, 35), width=6)
    draw.ellipse((290, 255, 340, 305), fill=(255, 243, 230), outline=(220, 220, 220), width=4)
    draw.ellipse((320, 270, 350, 300), fill=(15, 23, 42))
    draw.line((430, 235, 470, 210), fill=(255, 255, 255), width=6)
    draw.line((430, 315, 470, 340), fill=(255, 255, 255), width=6)
    return img


def crab():
    img, draw = make_canvas(bg=(253, 247, 239))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(252, 235, 215), outline=(230, 197, 155), width=6)
    draw.ellipse((180, 180, 620, 420), fill=(201, 107, 45), outline=(142, 70, 24), width=8)
    draw.ellipse((220, 150, 300, 240), fill=(201, 107, 45), outline=(142, 70, 24), width=8)
    draw.ellipse((500, 150, 580, 240), fill=(201, 107, 45), outline=(142, 70, 24), width=8)
    draw.ellipse((228, 260, 318, 350), fill=(201, 107, 45), outline=(142, 70, 24), width=8)
    draw.ellipse((482, 260, 572, 350), fill=(201, 107, 45), outline=(142, 70, 24), width=8)
    draw.ellipse((255, 250, 305, 310), fill=(255, 244, 232), outline=(220, 220, 220), width=4)
    draw.ellipse((495, 250, 545, 310), fill=(255, 244, 232), outline=(220, 220, 220), width=4)
    draw.ellipse((280, 280, 310, 310), fill=(15, 23, 42))
    draw.ellipse((520, 280, 550, 310), fill=(15, 23, 42))
    draw.arc((330, 330, 500, 420), 0, 180, fill=(142, 70, 24), width=8)
    return img


def squid():
    img, draw = make_canvas(bg=(242, 248, 255))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(226, 236, 255), outline=(190, 214, 242), width=6)
    draw.ellipse((170, 190, 630, 440), fill=(124, 147, 197), outline=(80, 103, 144), width=8)
    draw.ellipse((235, 180, 330, 290), fill=(124, 147, 197), outline=(80, 103, 144), width=8)
    draw.ellipse((470, 180, 565, 290), fill=(124, 147, 197), outline=(80, 103, 144), width=8)
    draw.ellipse((265, 265, 310, 315), fill=(255, 255, 255), outline=(220, 220, 220), width=4)
    draw.ellipse((290, 280, 310, 300), fill=(15, 23, 42))
    draw.arc((340, 320, 470, 420), 180, 360, fill=(80, 103, 144), width=8)
    draw.line((330, 245, 365, 245), fill=(255, 255, 255), width=4)
    draw.line((430, 245, 465, 245), fill=(255, 255, 255), width=4)
    return img


def bandeng():
    img, draw = make_canvas(bg=(255, 252, 240))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(253, 239, 214), outline=(237, 206, 145), width=6)
    draw.ellipse((150, 210, 650, 430), fill=(244, 185, 66), outline=(183, 122, 30), width=8)
    draw.ellipse((250, 215, 350, 320), fill=(255, 250, 227), outline=(220, 220, 220), width=4)
    draw.ellipse((280, 235, 315, 290), fill=(15, 23, 42))
    draw.polygon([(530, 250), (640, 220), (620, 330)], fill=(255, 220, 130), outline=(183, 122, 30), width=6)
    draw.line((360, 260, 440, 260), fill=(183, 122, 30), width=8)
    return img


def crackers():
    img, draw = make_canvas(bg=(252, 247, 237))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(247, 233, 199), outline=(219, 188, 133), width=6)
    draw.rectangle((180, 180, 620, 400), fill=(201, 124, 40), outline=(143, 79, 27), width=8)
    draw.rectangle((220, 220, 580, 360), fill=(242, 185, 98), outline=(143, 79, 27), width=6)
    draw.line((230, 220, 230, 360), fill=(143, 79, 27), width=6)
    draw.line((320, 220, 320, 360), fill=(143, 79, 27), width=6)
    draw.line((410, 220, 410, 360), fill=(143, 79, 27), width=6)
    draw.line((500, 220, 500, 360), fill=(143, 79, 27), width=6)
    return img


def lobster():
    img, draw = make_canvas(bg=(255, 248, 242))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(255, 230, 219), outline=(242, 195, 169), width=6)
    draw.ellipse((180, 190, 620, 420), fill=(255, 107, 107), outline=(180, 60, 90), width=8)
    draw.ellipse((240, 170, 345, 270), fill=(255, 107, 107), outline=(180, 60, 90), width=8)
    draw.ellipse((455, 170, 560, 270), fill=(255, 107, 107), outline=(180, 60, 90), width=8)
    draw.ellipse((270, 250, 310, 300), fill=(255, 244, 240), outline=(220, 220, 220), width=4)
    draw.ellipse((490, 250, 530, 300), fill=(255, 244, 240), outline=(220, 220, 220), width=4)
    draw.ellipse((290, 278, 310, 298), fill=(15, 23, 42))
    draw.ellipse((510, 278, 530, 298), fill=(15, 23, 42))
    return img


def tuna():
    img, draw = make_canvas(bg=(244, 250, 255))
    draw.rounded_rectangle((40, 60, 760, 540), 40, fill=(228, 243, 255), outline=(195, 219, 242), width=6)
    draw.ellipse((150, 220, 650, 430), fill=(30, 136, 229), outline=(13, 83, 161), width=8)
    draw.polygon([(470, 245), (620, 220), (600, 330)], fill=(13, 83, 161), outline=(13, 83, 161), width=6)
    draw.ellipse((250, 250, 340, 320), fill=(255, 255, 255), outline=(220, 220, 220), width=4)
    draw.ellipse((280, 270, 310, 300), fill=(15, 23, 42))
    draw.line((350, 280, 450, 280), fill=(255, 255, 255), width=6)
    return img


items = [
    ('kakap-merah.png', fish_red),
    ('udang-vaname.png', shrimp),
    ('rajungan.png', crab),
    ('cumi-beku.png', squid),
    ('bandeng-presto.png', bandeng),
    ('kerupuk-tenggiri.png', crackers),
    ('lobster.png', lobster),
    ('tuna.png', tuna),
]

for name, func in items:
    save(func(), name)
    print(f'created {name}')
