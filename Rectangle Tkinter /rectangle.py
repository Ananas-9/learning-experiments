import tkinter as tk

rectangle = None

def validate_number(text):
    return text.isdigit() or text == ""

def on_button_click():
    global canvas, a_entry, b_entry, r_entry, rectangle
    if rectangle is not None:
        canvas.delete(rectangle)
    x1 = 10
    y1 = 10
    x2 = x1 + int(a_entry.get())
    y2 = y1 + int(b_entry.get())
    r = int(r_entry.get())
    points = [x1 + r, y1,x2 - r, y1,x2, y1,x2, y1 + r,x2, y2 - r,x2, y2,x2 - r, y2,x1 + r, y2,x1, y2,x1, y2 - r,x1, y1 + r,x1, y1,]
    rectangle = canvas.create_polygon(points, smooth=True, splinesteps=100)


root = tk.Tk()
validnumber = (root.register(validate_number), '%P')
tk.Label(text="Радіус заокруглення").pack()
r_entry = tk.Entry(root, validate='key', validatecommand=validnumber)
r_entry.pack()
tk.Label(text="Сторона а").pack()
a_entry = tk.Entry(root, validate='key', validatecommand=validnumber)
a_entry.pack()
tk.Label(text="Сторона b").pack()
b_entry = tk.Entry(root, validate='key', validatecommand=validnumber)
b_entry.pack()
button = tk.Button(root, text="Побудувати прямокутник", command=on_button_click)
button.pack()
canvas = tk.Canvas(root, width=500, height=500)
canvas.pack()

root.mainloop()
