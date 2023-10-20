import {LayoutsName, TLayoutsName} from "../routes/types";

export function getLayout(name: TLayoutsName): Promise<string> {
  return new Promise(resolve => {
    const layoutName: TLayoutsName = name || LayoutsName.MAIN;

    resolve(`${layoutName[0].toUpperCase()}${layoutName.slice(1)}Layout`);
  });
}