import {onBeforeUnmount, onMounted, onUpdated, ref, watch, toRef} from "vue";

function useHeightCalculator(videos: any) {
  const heightCorrectionFactor: number = 107;
  const widthCorrectionFactor: number = 16;
  const aspectRatio: number = 1.2;

  const screenElement = ref<HTMLDivElement>();
  const screenWidth = ref<number>();
  const screenHeight = ref<number>();

  const calculate = (value: number = 0): void => {
    let height: number;
    let width: number;

    const heightBodyElement: number = document.body.clientHeight;
    screenWidth.value = screenElement.value!.clientWidth - widthCorrectionFactor - value;
    screenHeight.value = heightBodyElement - heightCorrectionFactor;

    switch (videos.value!.length) {
      case 1:
        height = screenHeight.value - 5;
        width = screenWidth.value - 5;
        setHeight(height, width);
        break;

      case 2:
        if ((screenWidth.value / screenHeight.value) > 1) {
          height = screenHeight.value - 5;
          width = (screenWidth.value / 2) - 10;
        } else {
          height = (screenHeight.value / 2) - 5;
          width = screenWidth.value - 5;
        }
        setHeight(height, width);
        break;

      default:
        const data: {width: number, height: number} = positionGridCalculation();

        data.width -= 10;
        data.height -= 5;

        if ((data.width / data.height) > aspectRatio) {
          data.width = data.height * aspectRatio;
        }

        setHeight(data.height, data.width);
    }
  }

  const positionGridCalculation = (
    row: number = 1
  ): {height: number, width: number} => {

    let data;
    const column: number = videos.value!.length / row;
    let width: number = (screenWidth.value! / Math.ceil(column));
    const height: number = (screenHeight.value! / row);

    if (((width / aspectRatio)) < height) {
      ++row;
      data = positionGridCalculation(row);
    } else {
      data = {
        width,
        height
      }
    }

    return data;
  }

  const setHeight = (height: number, width: number): void => {
    videos.value?.forEach((element: HTMLElement): void => {
      element.style.height = `${height}px`;
      element.style.width = `${width}px`;
    })
  }

  const addListener = () => {
    window.addEventListener('resize', () => calculate());
  }

  const removeListener = () => {
    window.removeEventListener('resize', () => calculate());
  }

  onMounted(() => {
    calculate();
    addListener();
  });

  onUpdated(() => {
    calculate();
  })

  onBeforeUnmount(() => {
    removeListener();
  })

  return {
    screenElement
  }
}

export default useHeightCalculator;
