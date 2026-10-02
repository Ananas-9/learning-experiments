import tkinter as tk

def validate_number(text):
    return text.isdigit() or text == ""

def on_button_click():
    global canvas, l_entry
    canvas.delete("all")
    x1 = 500-int(l_entry.get())/2
    x2 = x1 + int(l_entry.get())
    y1 = 500
    y2 = 500
    y_parallel = True
    end_points = [(x1,y1), (x2, y2)]
    canvas.create_line(end_points)
    l = float(l_entry.get())/3.0
    while l>0.05:
        new_points = []
        for point in end_points:
            if y_parallel:
                points = [(point[0], point[1]-l/2.0), (point[0], point[1]+l/2.0)]
                new_points.append((point[0], point[1]-l/2.0))
                new_points.append((point[0], point[1]+l/2.0))
                canvas.create_line(points)
            else:
                points = [(point[0]-l/2.0, point[1]), (point[0]+l/2.0, point[1])]
                new_points.append((point[0]-l/2.0, point[1]))
                new_points.append((point[0]+l/2.0, point[1]))
                canvas.create_line(points)
        end_points = new_points
        y_parallel=not y_parallel
        l/=3

root = tk.Tk()
validnumber = (root.register(validate_number), '%P')
tk.Label(text="Довжина першого відрізку").pack()
l_entry = tk.Entry(root, validate='key', validatecommand=validnumber)
l_entry.pack()
button = tk.Button(root, text="Побудувати фрактал", command=on_button_click)
button.pack()
canvas = tk.Canvas(root, width=1000, height=1000)
canvas.pack()

root.mainloop()
