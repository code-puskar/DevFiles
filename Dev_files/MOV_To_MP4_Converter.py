import os
from moviepy.editor import VideoFileClip

def convert_mov_to_mp4(input_file, output_file):
    try:
        # Check if the input file exists
        if not os.path.exists(input_file):
            raise FileNotFoundError(f"The file {input_file} does not exist.")
        
        # Load the .mov file
        clip = VideoFileClip(input_file)
        
        # Write the video clip as an mp4 file
        clip.write_videofile(output_file, codec='libx264')
        
        # Close the video clip
        clip.close()
        
        print(f"Conversion successful! {output_file} has been created.")
    
    except PermissionError:
        print(f"Permission denied: Unable to write to {output_file}. Check your permissions.")
    except FileNotFoundError as e:
        print(e)
    except Exception as e:
        print(f"An unexpected error occurred: {e}")

# Usage
input_file = r"C:\Users\puska\OneDrive\Documents\GitHub\DevFiles\Dev_files\IMG_6235.MOV"
output_file = "DR4  .mp4"

convert_mov_to_mp4(input_file, output_file)
