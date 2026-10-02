import tkinter as tk
import random

points=[]

def clear_all():
    global canvas, points
    canvas.delete("all")
    points = []

def clear_last():
    global canvas, points
    canvas.delete("all")
    points.pop()
    if len(points)==0:
        pass
    elif len(points) == 1:
        canvas.create_oval(points[0][0]-5, points[0][1]-5, points[0][0]+5, points[0][1]+5)
    elif len(points) == 2:
        canvas.create_line(points)
    else:
        canvas.create_polygon(points, fill="", outline="white")

def add_point(event):
    global points, canvas
    canvas.delete("all")
    points.append((event.x, event.y))
    if len(points) == 1:
        canvas.create_oval(event.x-5, event.y-5, event.x+5, event.y+5)
    elif len(points) == 2:
        canvas.create_line(points)
    else:
        canvas.create_polygon(points, fill="", outline="white")

def on_button_click():
    global points
    side1 = random.randint(-1, len(points)-2)
    l1 = random.randint(1, 1000) / 500
    p1 = ((points[side1][0] + l1 * points[side1 + 1][0]) / (1 + l1), (points[side1][1] + l1 * points[side1 + 1][1])/(1+l1))
    side2 = random.randint(-1, len(points)-2)
    l2 = random.randint(1, 1000) / 500
    p2 = ((points[side2][0] + l2 * points[side2 + 1][0]) / (1 + l2), (points[side2][1] + l2 * points[side2 + 1][1])/(1+l2))
    canvas.create_line(p1, p2)

root = tk.Tk()
tk.Button(root, text="Побудувати випадкову похилу", command=on_button_click).pack()
tk.Button(root, text="Очистити полотно", command=clear_all).pack()
tk.Button(root, text="Видалити останню точку", command=clear_last).pack()
tk.Label(root, text="Натискайте на місце майбутніх точок, щоб створити багатокутник").pack()
canvas = tk.Canvas(root, width=500, height=500)
canvas.pack()
canvas.bind("<Button 1>", add_point)
root.mainloop()
